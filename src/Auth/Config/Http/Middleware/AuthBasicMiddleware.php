<?php namespace HaziCms\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;

class AuthBasicMiddleware {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Know if the connected user is admin.
     *
     * @var Boolean
     */
    private $isAdmin;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct()
    {
        $this->user = \Auth::user();
        $this->isAdmin = false;
        // dd($this->user);
        if ($this->user->is('admin')) $this->isAdmin = true;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      // $this->makeIlogicalCan();
        switch ($request->method()) {
            case 'GET':
                if($request->segment(3) == 'create') {
                    $this->makeAuthentization('create', 'posts');
// dd($request->segment(3));
                } elseif($request->segment(4) == 'edit') {
                    $id = $request->segment(3);
                    $this->makeAuthentization('edit', 'posts', (int)$id);
                }
                break;

            case 'POST':
                $this->makeAuthentization('create', 'posts');
                break;

            case 'PUT':
                $id = $request->segment(3);
                $this->makeAuthentization('edit', 'posts', (int)$id);
                break;

            case 'DELETE':
                $id = $request->segment(3);
                $this->makeAuthentization('delete', 'posts', (int)$id);
                break;
        }

		return $next($request);
	}

    /**
     * Fuerza que el $this->lock de LockAware este seteado
     */
    // private function makeIlogicalCan()
    // {
    //     return \Lock::can('fake', 'ilogical', 'can');
    // }

    /**
     * Get the group name from a connected user.
     *
     * @return mixed
     */
    // private function getGroupName()
    // {
    //     if (! isset(\Auth::user()->id)) return null;

    //     $userId = \Auth::user()->id;
    //     $sql = 'SELECT ro.id as role_id, ro.name as role_name,u.id as user_id, u.name as user_name
    //     FROM roleables as r
    //     INNER JOIN roles as ro ON ro.id = r.role_id
    //     INNER JOIN users as u ON u.id = r.caller_id
    //     WHERE r.caller_type="users" and r.caller_id='.$userId;

    //     $group = \DB::select(\DB::raw($sql));

    //     return $group[0]->role_name;
    // }

    /**
     * Know if the user can action on resource.
     *
     * @param $action
     * @param $resource
     * @param $id
     * @throws \HaziCms\Exceptions\PermissionDeny
     */
    private function makeAuthentization($action, $resource, $id=null)
    {
        if (!$this->isAdmin) {
            if(is_null($id)) {
               if (!$this->user->can($action . "." . $resource)) {
                    throw new \HaziCms\Exceptions\PermissionDeny('you dont have permission to '.$action.' '.$resource.'.');
                }
            } else {

                // $model = "HaziCms\Modules\Blog\Entities\\".substr(ucfirst($resource), 0, -1);
                // $data = $model::find($id);
                // dd($data);
                // if (!$this->auth->user()->can($action, $resource)) {
                
                if (!$this->user->can($action . "." . $resource)) { 
                    throw new \HaziCms\Exceptions\PermissionDeny('you dont have permission to '.$action.' '.$resource.'.');
                }

                $sql = "SELECT user_id FROM ". $resource ." WHERE id = ".$id;
                $data = \DB::select(\DB::raw($sql));

                $user_id = $this->user->id;
                
                // dd($this->user->id);
                //dd($data[0]->user_id);
                
                if($user_id !== $data[0]->user_id) {
                    throw new \HaziCms\Exceptions\PermissionDeny('you dont have permission to '.$action.' '.$resource.'.');
                }
            }
        }
    }

}
