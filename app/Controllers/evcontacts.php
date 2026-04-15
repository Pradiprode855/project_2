<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Evcontacts extends ResourceController
{
    public function conpage()
    {
        $db = \Config\Database::connect();
        try {
            $db->query('SELECT 1');
            echo "✅ Database connected successfully!";
        } catch (\Exception $e) {
            echo "❌ Connection failed: " . $e->getMessage();
        }

    }
   public function contact()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message1');
        // echo $message1;
        // $data1 = $this->request->getJSON(true);
        $db = \Config\Database::connect();
         

        $builder = $db->table('contacts');
        $message2 ="Please Enter Inforamtion";
        $data = [
                    'name'    => $name,
                    'email'   => $email,
                    'subject'    => $subject,
                    'message'    => $message
                    ];
            // $jsonData = json_encode($data);
        if($name == NULL && $email == NULL && $subject == NULL && $message == NULL)
        {
            echo "<script>
                  alert(" . json_encode($message2) . ");
                //   window.location.href = 'http://localhost/project_2/public/';
                  </script>";
        }
        else
        {
             if($builder->insert($data))
             {
                $message = "Contact Add successfull ";  
                echo "<script>
                  alert(" . json_encode($message) . ");
                //   window.location.href = 'http://localhost/project_2/public/';
                  </script>";
             }

        }
    }
}