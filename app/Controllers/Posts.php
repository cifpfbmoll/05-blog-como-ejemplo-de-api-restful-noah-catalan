<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Posts extends ResourceController
{
    protected $modelName = 'App\Models\PostModel';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $post = $this->model->find($id);
        
        if ($post === null) {
            return $this->failNotFound('Post no encontrado');
        }
        
        return $this->respond($post);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true);
        
        // Validación
        $rules = [
            'title' => 'required|min_length[5]',
            'content' => 'required|min_length[10]',
            'category' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        
        // Convertir tags a JSON si es un array
        if (isset($data['tags']) && is_array($data['tags'])) {
            $data['tags'] = json_encode($data['tags']);
        }
        
        $id = $this->model->insert($data);
        
        if ($id === false) {
            return $this->fail($this->model->errors());
        }
        
        return $this->respondCreated($this->model->find($id), 'Post creado exitosamente');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        
        // Validación (menos estricta para actualización)
        $rules = [
            'title' => 'permit_empty|min_length[5]',
            'content' => 'permit_empty|min_length[10]',
            'category' => 'permit_empty'
        ];
        
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        
        $post = $this->model->find($id);
        
        if ($post === null) {
            return $this->failNotFound('Post no encontrado');
        }
        
        // Convertir tags a JSON si es un array
        if (isset($data['tags']) && is_array($data['tags'])) {
            $data['tags'] = json_encode($data['tags']);
        }
        
        $this->model->update($id, $data);
        
        return $this->respond($this->model->find($id), 200, 'Post actualizado exitosamente');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $post = $this->model->find($id);
        
        if ($post === null) {
            return $this->failNotFound('Post no encontrado');
        }
        
        $this->model->delete($id);
        
        return $this->respondDeleted($post, 'Post eliminado exitosamente');
    }

    /**
     * Search posts by term in title, content, or category.
     *
     * @return ResponseInterface
     */
    public function search()
    {
        $term = $this->request->getGet('term');
        
        if ($term === null || $term === '') {
            return $this->fail('Debes proveer un término de búsqueda');
        }
        
        $posts = $this->model
            ->like('title', $term)
            ->orLike('content', $term)
            ->orLike('category', $term)
            ->findAll();
        
        return $this->respond($posts);
    }
}
