<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\Controller;use App\Core\Request;use App\Core\Response;use App\Models\Category;use App\Services\AuthService;use Closure;use PDO;use PDOException;

final class CategoryController extends Controller
{
    public function __construct(private readonly Closure $pdoFactory,private readonly AuthService $auth,\App\Core\View $view){parent::__construct($view);}
    public function index(Request $r):void{$this->auth->requireRole(['admin']);$keyword=trim((string)$r->query('keyword',''));$status=(string)$r->query('status','all');if(!in_array($status,['all','active','hidden'],true))$status='all';$categories=(new Category($this->pdo()))->search($keyword,$status);$this->render('admin.categories.index',compact('keyword','status','categories')+['pageTitle'=>'Quản lý danh mục','adminPage'=>'categories'],'layouts.admin');}
    public function add(Request $r):void{$this->form($r,null);}
    public function edit(Request $r):void{$this->form($r,(int)$r->query('id',0));}
    private function form(Request $r,?int $id):void
    {
        $this->auth->requireRole(['admin']);$model=new Category($this->pdo());$category=$id===null?null:$model->find($id);
        if($id!==null&&!$category)Response::abort(404,'Không tìm thấy danh mục.');
        $values=['name'=>$category['name']??'','slug'=>$category['slug']??'','description'=>$category['description']??'','status'=>$category['status']??'active'];$message='';
        if($r->isPost()){verifyCsrf();foreach($values as $key=>$value)$values[$key]=trim((string)$r->input($key,$value));
            if($values['name']===''||$values['slug']==='')$message='Vui lòng nhập đầy đủ tên danh mục và slug.';
            elseif(!in_array($values['status'],['active','hidden'],true))$message='Trạng thái danh mục không hợp lệ.';
            else try{$id===null?$model->create($values):$model->update($id,$values);Response::redirect(BASE_URL.'views/categories.php');}
            catch(PDOException $e){$message=$e->getCode()==='23000'?'Tên danh mục hoặc slug đã tồn tại.':'Không thể lưu danh mục.';}
        }
        $this->render($id===null?'admin.categories.add':'admin.categories.edit',compact('values','message','category','id'));
    }
    public function delete(Request $r):void{$this->auth->requireRole(['admin']);$id=(int)$r->query('id',0);$model=new Category($this->pdo());$category=$model->find($id);if(!$category)Response::abort(404,'Không tìm thấy danh mục.');$message='';if($r->isPost()){verifyCsrf();if((int)$category['post_count']>0)$message='Không thể xóa danh mục đang có bài viết.';else try{$model->delete($id);Response::redirect(BASE_URL.'views/categories.php');}catch(PDOException){$message='Không thể xóa danh mục đang được sử dụng.';}}$this->render('admin.categories.delete',compact('category','message','id'));}
    private function pdo():PDO{return ($this->pdoFactory)();}
}
