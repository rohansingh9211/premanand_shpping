<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class BannerApi extends ResourceController
{

    protected $modelName = 'App\Models\BannerModel';
    protected $format = 'json';

    public function upload_banner()
    {
        $validationRule = [
            'image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[image]'
                    . '|is_image[image]'
                    . '|mime_in[image,image/jpg,image/jpeg,image/gif,image/png]'
                    . '|max_size[image,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return $this->fail($this->validator->getErrors());
        }

        $img = $this->request->getFile('image');
        if (!$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(WRITEPATH . 'uploads', $newName);

            $imageData = [
                'image' => file_get_contents(WRITEPATH . 'uploads/' . $newName)
            ];

            $this->model->insert_image($imageData);

            return $this->respondCreated(['status' => 'Image uploaded successfully.']);
        }

        return $this->fail('The file has already been moved.');
    }

    public function Getbanner($id = null)
    {
        if ($id === null) {
            return $this->fail('Image ID is required.', 400); // 400 Bad Request
        }
        try {
            $imageData = $this->model->get_image($id);

            if ($imageData) {
                $image = $imageData['image'];
                $base64Image = base64_encode($image);
                $mimeType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);

                // Return JSON response with image data as base64 and ID
                return $this->respond([
                    'id' => $id,
                    'mimeType' => $mimeType,
                    'image' => $base64Image
                ]);
            } else {
                return $this->failNotFound('Image not found.');
            }
        } catch (Exception $e) {
            log_message('error', 'Error fetching image: ' . $e->getMessage());

            // Return a 500 Internal Server Error response
            return $this->failServerError('An error occurred while fetching the image.');
        }
    }
    

}