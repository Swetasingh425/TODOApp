 <?php
namespace App\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Class ToDoAppService {

    public static function registerUser($userDetails) {
        $data = array('name' => $userDetails["name"], 'email' => $userDetails["email"], 'password' => $userDetails["password"]);
        DB::table('users')->insert($data);
        return [
            "status" => "ok"
        ];
    }

    public static function login($userDetails, $request){
        $password = DB::table('users')->where("email", $userDetails["email"])->value("password");
        if($password === $userDetails["password"]) {
            $request->session()->put('email', $userDetails["email"]);
            return [
                "status" => "Ok",
                "message" => "Login Successful"
            ];
        } else {
            return [
                "status" => "Fail",
                "message" => "Invlid username or password"
            ];
        }
    }

    public static function createToDo($toDoDetails, $request){
        $data = array(
            'name' => $toDoDetails["name"],
            'start_date' => $toDoDetails["startDate"],
            'due_date' => $toDoDetails["dueDate"],
            'description' => $toDoDetails["description"],
            'completed' => false,
            'created_by' => $request->session()->get('email')
        );
        //dd($data);
        $id = DB::table('todo')->insertGetId($data);
        return [
            "status" =>"ok",
            "data" => [
                "id" => $id
            ]
        ];
    }

    public static function updateToDo($toDoDetails, $request){
        $data = array();
        if(isset($toDoDetails['name'])) {
            $data['name'] = $toDoDetails['name'];
        }

        if(isset($toDoDetails['startDate'])){
            $data['start_date'] = $toDoDetails['startDate'];
        }

        if(isset($toDoDetails['dueDate'])){
            $data['due_date'] = $toDoDetails['dueDate'];
        }

        if(isset($toDoDetails['description'])){
            $data['description'] = $toDoDetails['description'];
        }

        DB::table('todo')->where("id", $toDoDetails["id"])->update($data);
        return [
            "status" => "ok",
            "message" => "update succussful"
        ];

    }

    public static function listToDo($request){

        $emailId = $request->session()->get("email");
        $result = DB::table('todo')->select('id', 'name', 'start_date', 'due_date')->where('created_by', $emailId)->get()->all();
        $response = [];

        foreach($result as $key => $value) {
            $response[$key]["id"] = $value->id;
            $response[$key]["name"] = $value->name;
            $response[$key]["startDate"] = $value->start_date;
            $response[$key]["dueDate"] = $value->due_date;
        }
        return [
           "status" => "ok",
           "data" => [
               "toDoList" => $response
           ]
        ];
    }

    public static function getToDoDetails($request, $id){
        $emailId = $request->session()->get("email");
        $completedValues = ["No", "Yes"];
        $result = DB::table('todo')->where('id', $id)->get()->all();
        $response =[];
        $response["id"] = $result[0]->id;
        $response["name"] = $result[0]->name;
        $response["description"] = $result[0]->description;
        $response["startDate"] = $result[0]->start_date;
        $response["dueDate"] = $result[0]->due_date;
        $response["createdOn"] = $result[0]->created_at;
        $response["completed"] = $completedValues[$result[0]->completed];
        return [
            "status" => "ok",
            "data" => $response
        ];
    }

    public static function completeToDo($request, $id){
        $emailId = $request->session()->get("email");
        $data = [
            "completed" => true
        ];
        DB::table('todo')->where('id', $id)->update($data);
        return [
            "status" => "ok",
            "message" => "ToDoCompleted"
        ];
    }
}
