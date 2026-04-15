<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class Courses extends ResourceController
{
    protected $format = 'json';

    public function add_courses()
    {
    try {
        $db = \Config\Database::connect();
        $builder = $db->table('courses');

        // Get text fields
        $title              = $this->request->getPost('title');
        $slug               = $this->request->getPost('slug');
        $description        = $this->request->getPost('description');
        $content            = $this->request->getPost('content');
        $overview           = $this->request->getPost('overview');
        $career_opportunity = $this->request->getPost('career_opportunity');
        $category_id        = $this->request->getPost('category_id');
        $duration           = $this->request->getPost('duration');
        $price              = $this->request->getPost('price');

        // Handle file upload
        $file = $this->request->getFile('pdf_file');
        $newName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
        }

        // Prepare data
        $data = [
            'title'              => $title,
            'slug'               => $slug,
            'description'        => $description,
            'content'            => $content,
            'overview'           => $overview,
            'career_opportunity' => $career_opportunity,
            'category_id'        => $category_id,
            'duration'           => $duration,
            'price'              => $price,
            'pdf_file'           => $newName
        ];

        if ($builder->insert($data)) {
            return $this->respondCreated([
                'message' => 'Course inserted successfully',
                'pdf_status' => $newName ? 'File uploaded successfully' : 'No PDF uploaded'
            ]);
        } else {
            return $this->fail('Failed to insert course');
        }

    } catch (\Exception $e) {
        return $this->failServerError('Error: ' . $e->getMessage());
    }
  }

     public function courses_view()
     {
        try {
            $db = Database::connect();
            $builder = $db->table('courses');
            $data = $builder->get()->getResultArray();
            return $this->respond($data);
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
        

     }
    public function delete_courses()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('courses');
            $id = $this->request->getGet('id');
            $data = $builder->get()->getResultArray();
            foreach($data as $course)
            {
                if($course['id'] == $id)
                {
                    $k=1;
                    break;
                }
            }
            
           if($k==1)
           {
              $builder->where('id', $id);
              $builder->delete();
              return $this->respondDeleted([
                    'message' => 'Course deleted successfully',
                ]);
            }         
            else  
                return $this->failNotFound('Course not found');  
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }
     
}