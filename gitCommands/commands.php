git init
git add *
git commit -m "First Save"
git remote add origin https://github.com/ar9786/verkoop.git-->your url
git push origin master || 
git status


for cloning
git clone ar9786@host:https://github.com/ar9786/Curl---


Laravel commands
    composer create-project --prefer-dist laravel/laravel firstprojct
inside project folder run this command 
    php artisan serve
For migration
    php artisan make:migration admin
    php artisan migrate --path=/database/migrations/2019_01_03_110158_create_post_tables.php
For making controllers
    php artisan make:controller <controller-name>
created controller can be called from routes.php
    Route::get(‘base URI’,’controller@method’);
created model 
    php artisan make:model Car --migration

To know more Blade Template go through below link
https://laravel.com/docs/5.1/blade

https://laravel.com/docs/5.7/queries
https://www.tutorialspoint.com/laravel/insert_records.htm
https://medium.com/@hdcompany123/laravel-5-7-and-json-web-tokens-tymon-jwt-auth-d5af05c0659a
https://www.codermen.com/blog/66/laravel-5-7-facebook-login-tutorial-step-by-step


https://www.harshittripathi.in/how-to-use-instagram-login-with-laravel-5/

Mail Code
	public function user_askquestion(Request $request) {
		
		 $response=array();
       
            
            $statusCode = 200;
            $rules=['name'=>'required','email'=>'required|email','question'=>'required'];
			$validator = Validator::make(collect($request)->toArray(), [
				'name' => 'required|max:255',
				'email' => 'required|email|max:255',
				'question'=>'required|min:6'
			]);
            if ($validator-> fails()){
            return response()->json($validator->errors(), 200);
			}else{
                $message=$request->question;
                $email=$request->email;
                $name=$request->name;
                //$toemail="info@bibleask.org";
				$toemail="deepak@mobilecoderz.com";
                $data = array(); 
                $data['from']       = $email; 
                $data['from_name']  = $name; 
                $data['to']         = $toemail; 
                $data['subject']    = 'Ask question';

                //$content            = "Hello Admin,<br/>Please find the following information<br>"; 
                $content            = "Name : ".ucfirst($name)."<br/>"; 
                $content            .= "Email : ".$email."<br/>"; 
                $content            .= "Question : ".$message."<br/>"; 

                Mail::send('email.common',['content'=>$content], function ($mail) use ($data) {
                    $mail->from($data['from'], $data['from_name']);
                    $mail->to($data['to'],'')->subject($data['subject']);
                });
    
                if( count(Mail::failures()) > 0 ) {

                   $response['success']=false;
                   $response['error_log']=Mail::failures();
                }
                else
                {
                  $response['success']=true;
				  $response['msg']='Thank you for your message. It has been sent.';
                }
            }
            
            return Response::json($response, $statusCode);
	}
DB::enableQueryLog();
dd( DB::getQueryLog() );



find /opt/lampp/htdocs -type d -exec chmod 755 {} \;

find /opt/lampp/htdocs -type f -exec chmod 644 {} \;

rm -rf *
rm {file-name}
rm [options] {file-name}
unlink {file-name}
rm -f -r {file-name}
sudo chown abhishek -v magentoinstall/*

rm -rf magentoinstall
https://www.tecmint.com/10-most-dangerous-commands-you-should-never-execute-on-linux/


https://community.magento.com/t5/Magento-2-x-Version-Upgrades/Invalid-response-line-returned-from-server-HTTP-2-200/m-p/113940#M1543