<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:AddUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add New User';

    private $roles = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $confirm = $this->confirmYN("Are you sure you want to create a new User?");
        if(!$confirm) exit();
        readline("Next, please select which roles you would like this new user to have. Press Enter to continue...");
        
        $roles = Role::all();
        $roleIDs = [];
        foreach($roles as $role) {
            $roleIDs[] = $role->id;
        }

        $input = 1;
        while($input > 0 || count($this->roles) == 0) {
            $this->showRoles($roles); 
            $input = readline("\nPlease select a Role to toggle or press 'n' to next: ");
            
            if(strtolower($input) == "q") {
                exit();
            } else if(strtolower($input) == "n" && count($this->roles) == 0){
                continue;
            } else if(strtolower($input) == "n"){
                break;
            } 
            
            if(!in_array($input, $roleIDs)) {
                echo "Please choose a valid Role ID. Hit Enter to continue...\n";
                continue;
            }
            if(in_array($input, $this->roles)) {                
                $input_roles = $this->roles;
                unset($input_roles[$input]);
                $this->roles = $input_roles; 
                continue;
            }

            $this->roles[$input] = $input;            
        }
        
        $name       = readline("Name: ");
        $email      = readline("Email Address: ");
        $password   = readline("Password: ");

        try{
            $user = new User();
            $user->name     = $name;
            $user->email    = $email;
            $user->password = Hash::make($password);
            
            if($user->save()) {
                $roles = Role::whereIn('id', $this->roles)->get();
        
                // Assign the role to the user
                $user->roles()->sync($roles);
                echo "User saved with ID " . $user->id."\n";
            } else {
                echo "There was a problem saving the user. Please try again later.\n";
            }
        }
        catch(\Exception $e){
            // do task when error
            echo $e->getMessage();
        }        
        exit();

    }

    private function showRoles($roles) {

        //select roles
        foreach ($roles as $key => $role) {
            $selected = in_array($role->id, $this->roles) ? "X" : " ";
            echo "[{$selected}] {$role->id} : $role->name \n";        
        }
        echo "  n. NEXT\n";
        echo "  q. QUIT\n";
    }    

    private function confirmYN($msg, $default="y") {
      $yes  = $default == "y" ? "Y" : "y";
      $no   = $default == "n" ? "N" : "n";

      $msg.= " [".$yes."/".$no."]: ";
      $response = readline($msg);

      if(!$response) $response = $default;
      $response = strtolower($response);

      if($response == "y") return true;
      if($response == "n") return false;

      return $this->confirmYN("Please enter either 'y' or 'n': ");

    }

}
