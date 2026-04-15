<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class Admin extends ResourceController
{
    protected $format = 'json';

    public function admin_login()
    {
        try {
            $db = Database::connect();
            $builder = $db->table('admin');


            $id       = $this->request->getGet('id');
            $email    = $this->request->getGet('email');
            $password = $this->request->getGET('password');

            
            if (!$email || !$password) {
                return $this->fail('Email and password are required');
            }

            $query = $builder->get();
            $result = $query->getResultArray();

            $flag = 0;
            foreach ($result as $row) {
                if ($row['id'] == $id && $row['email'] == $email && password_verify($password, $row['pass']))
                 {
                    $flag = 1;
                    break;
                }
            }

            if ($flag == 1) {
                return $this->respond(['message' => '✅ User is present']);
                // echo "user is present";
            } else {
                return $this->fail('❌ Invalid credentials');
            }

        } catch (\Exception $e) {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
    }

    public function contact()
    {
       $db = Database::connect();
       $name = $this->request->getGet('name'); 
       $email = $this->request->getGet('email');
       $subject = $this->request->getGet('subject');
       $message = $this->request->getGet('message');
         try {
             if ($name == NULL || $email == NULL || $subject == NULL || $message == NULL)
            {
                return $this->fail('All fields are required');
            }
            else
                { 
                        $db = Database::connect();
                        $builder = $db->table('contact_us');
                        $data = [
                                'name'       => $this->request->getVar('name'),
                                'email'      => $this->request->getVar('email'),
                                'subject'    => $this->request->getVar('subject'),
                                'message'    => $this->request->getVar('message')
                         ];
                        $builder->insert($data);
                        
                        return $this->respondCreated(['message' => '✅ Contact saved successfully']);
                }
        } catch (\Exception $e) {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
       }
         public function contact_view()
        {
        try {
            $db = Database::connect();
            $builder = $db->table('contact_us');
            $data = $builder->get()->getResultArray();
            return $this->respond($data);
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }
    public function delete_contact()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('contact_us');
            $id = $this->request->getGet('id');
            $data = $builder->get()->getResultArray();
            foreach($data as $contact)
            {
                if($contact['id'] == $id)
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
                    'message' => 'contact deleted successfully',
                ]);
            }         
            else  
                return $this->failNotFound('contact not found');  
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }

    public function get_courses_by_id()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('courses');
            $id = $this->request->getGet('id');
            $data = $builder->get()->getResultArray();
            foreach($data as $a)
            {
                if($a['id'] == $id)
                {
                    return $this->respond($a);
                    break;
                }
                else
                {
                    $k=1;
                }
            }
            
           if($k==1)
           {
              return $this->respondDeleted([
                    'message' => 'courses is not found..',
                ]);
            }          
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }

    public function get_courses_by_slug()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('courses');
            $slug = $this->request->getGet('slug');
            $data = $builder->get()->getResultArray();
            foreach($data as $a)
            {
                if($a['slug'] == $slug)
                {
                    return $this->respond($a);
                    break;
                }
                else
                {
                    $k=1;
                }
            }
            
           if($k==1)
           {
              return $this->respondDeleted([
                    'message' => 'slug is not found..',
                ]);
            }          
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }


    public function get_courses_by_id_update()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('courses');
            $id = $this->request->getGet('id');
            $data = $builder->get()->getResultArray();
            foreach($data as $a)
            {
                if($a['id'] == $id)
                {
                        $data = [
                        'title'              => $this->request->getVar('title') ?? $a['title'],
                        'slug'               => $this->request->getVar('slug') ?? $a['slug'],
                        'description'        => $this->request->getVar('description') ?? $a['description'],
                        'content'            => $this->request->getVar('content')   ?? $a['content'],
                        'overview'           => $this->request->getVar('overview')  ?? $a['overview'],
                        'career_opportunity' => $this->request->getVar('career_opportunity')    ?? $a['career_opportunity'],
                        'category_id'        => $this->request->getVar('category_id')   ?? $a['category_id'],
                        'duration'           => $this->request->getVar('duration')  ?? $a['duration'],
                        'price'              => $this->request->getVar('price') ?? $a['price'],
                        ];
                           $pdfFile = $this->request->getFile('pdf_file');

                            if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
                                // Make upload folder if not exists
                                $uploadPath = FCPATH . 'uploads/pdfs/';
                                if (!is_dir($uploadPath)) {
                                    mkdir($uploadPath, 0777, true);
                                }

                                // Delete old PDF if exists
                                if (!empty($course['pdf_file']) && file_exists($uploadPath . $course['pdf_file'])) {
                                    unlink($uploadPath . $course['pdf_file']);
                                }

                                // Move new PDF
                                $newPdfName = 'course_' . $id . '_' . time() . '.' . $pdfFile->getClientExtension();
                                $pdfFile->move($uploadPath, $newPdfName);
                                $data['pdf_file'] = $newPdfName;
                            }

                        if ($builder->where('id', $id)->update($data)) {
                        return $this->respondCreated([
                            'message' => 'Course update successfully',
                        ]);
                        } else {
                        return $this->fail('Failed to update course');
                        }
                        $k=1;

                    break;
                }
                else
                {
                    $k=1;
                }
            }
            
           if($k==1)
           {
              return $this->respondDeleted([
                    'message' => 'Id is not found..',
                ]);
            }          
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }
      
    public function add_review()
    {
        try {
            $db = Database::connect();
            $builder = $db->table('testimonials');

            $data = [
                'name'    => $this->request->getVar('name'),
                'reviews' => $this->request->getVar('reviews')
            ];

            if ($builder->insert($data)) {
                return $this->respondCreated([
                    'message' => 'Review inserted successfully',
                ]);
            } else {
                return $this->fail('Failed to insert review');
            }
    }
    catch (\Exception $e) 
    {
            return $this->failServerError('Error: '.$e->getMessage());
        }
    }
     public function review_view()
    {
        try {
            $db = Database::connect();
            $builder = $db->table('testimonials');
            $data = $builder->get()->getResultArray();

            if (empty($data)) {
                return $this->respond(['message' => 'No testimonials found']);
            }

            return $this->respond($data);

        } catch (\Exception $e) {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
    }
     public function delete_review()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('testimonials');
            $id = $this->request->getGet('id');
            $data = $builder->get()->getResultArray();
            foreach($data as $contact)
            {
                if($contact['id'] == $id)
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
                    'message' => 'testimonials deleted successfully',
                ]);
            }         
            else  
                return $this->failNotFound('testimonials not found');  
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }
    public function add_blog()
    {
        try {
            $db = Database::connect();
            $builder = $db->table('blog');

            $data = [
                'title'       => $this->request->getVar('title'),
                'slug'     => $this->request->getVar('slug'),
                'description'   => $this->request->getVar('description')
            ];

            if ($builder->insert($data)) {
                return $this->respondCreated([
                    'message' => 'Blog inserted successfully',
                ]);
            } else {
                return $this->fail('Failed to insert blog');
            }

        } catch (\Exception $e) {
            return $this->failServerError('Error: '.$e->getMessage());
        }
    }
    public function view_blog()
    {
         try {
            $db = Database::connect();
            $builder = $db->table('blog');
            $data = $builder->get()->getResultArray();

            if (empty($data)) {
                return $this->respond(['message' => 'No blog found']);
            }

            return $this->respond($data);

        } catch (\Exception $e) {
            return $this->failServerError('Error: ' . $e->getMessage());
        }                                     
    }
     public function delete_blog()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('blog');
            $id = $this->request->getGet('id');
            $data = $builder->get()->getResultArray();
            foreach($data as $contact)
            {
                if($contact['id'] == $id)
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
                    'message' => 'Blog deleted successfully',
                ]);
            }         
            else  
                return $this->failNotFound('blog not found');  
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }
    public function add_services()
    {
        try {
            $db = Database::connect();
            $builder = $db->table('services');

            $data = [
                'services_name'=> $this->request->getVar('services_name'),
                'slug'=> $this->request->getVar('slug'),
                'description'=> $this->request->getVar('description')
            ];

            if ($builder->insert($data)) {
                return $this->respondCreated([
                    'message' => 'services inserted successfully',
                ]);
            } else {
                return $this->fail('Failed to insert services');
            }

        } catch (\Exception $e) {
            return $this->failServerError('Error: '.$e->getMessage());
        }
    }
    public function view_services()
    {
         try {
            $db = Database::connect();
            $builder = $db->table('services');
            $data = $builder->get()->getResultArray();

            if (empty($data)) {
                return $this->respond(['message' => 'No services found']);
            }

            return $this->respond($data);

        } catch (\Exception $e) {
            return $this->failServerError('Error: ' . $e->getMessage());
        }                                     
    }
     public function delete_services()
     {
        $k=0;
        try {
            $db = Database::connect();
            $builder = $db->table('services');
            $id = $this->request->getGet('id');
            $data = $builder->get()->getResultArray();
            foreach($data as $contact)
            {
                if($contact['id'] == $id)
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
                    'message' => 'services deleted successfully',
                ]);
            }         
            else  
                return $this->failNotFound('services not found');  
        } 
        catch (\Exception $e) 
        {
            return $this->failServerError('Error: ' . $e->getMessage());
        }
     }
     public function pdf_download()
     {
      try {
        $db = \Config\Database::connect();
        $builder = $db->table('courses');

        $id = $this->request->getGet('id');
        $course = $builder->where('id', $id)->get()->getRowArray();

        if (!$course) {
            return $this->failNotFound('id not found');
        }

        // Assuming you have a column 'pdf_file' storing the file path
        $filePath = WRITEPATH . 'uploads/' . $course['pdf_file']; 

        if (!file_exists($filePath)) {
            return $this->failNotFound('PDF file not found on server');
        }

        return $this->response
            ->download($filePath, null)
            ->setFileName('course_' . $id . '.pdf');
    } 
    catch (\Exception $e) {
        return $this->failServerError('Error: ' . $e->getMessage());
    }
   }
    public function contact_for_pdf()
    {
        try {
            $db = Database::connect();
            $builder = $db->table('leads');

            $data = [
                'name'=> $this->request->getVar('name'),
                'email'=> $this->request->getVar('email'),
                'phone'=> $this->request->getVar('phone'),
                'pdf_id'=> $this->request->getVar('pdf_id')
            ];

            if ($builder->insert($data)) {
                return $this->respondCreated([
                    'message' => 'Recode inserted successfully',
                ]);
            } else {
                return $this->fail('Failed to insert ');
            }

        } catch (\Exception $e) {
            return $this->failServerError('Error: '.$e->getMessage());
        }
    }
}