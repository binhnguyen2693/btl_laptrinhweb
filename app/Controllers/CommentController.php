<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\Controller;use App\Core\Request;use App\Core\Response;use App\Models\Comment;use App\Services\AuthService;use Closure;use PDO;

final class CommentController extends Controller
{
    public function __construct(private readonly Closure $pdoFactory,private readonly AuthService $auth,\App\Core\View $view){parent::__construct($view);}
    public function index(Request $r):void{$this->auth->requireRole(['admin']);$keyword=trim((string)$r->query('keyword',''));$filter=(string)$r->query('status','all');$postId=(int)$r->query('post_id',0);$model=new Comment($this->pdo());$danhSachBaiViet=$model->posts();$binhLuan=$model->search($keyword,$filter,$postId);$csrfToken=csrfToken();$basePath='../';$thongBao='';$this->render('admin.comments.index',compact('keyword','filter','postId','danhSachBaiViet','binhLuan','csrfToken','basePath','thongBao')+['pageTitle'=>'Quản lý bình luận','adminPage'=>'comments'],'layouts.admin');}
    public function detail(Request $r):void{$this->auth->requireRole(['admin']);$id=(int)$r->query('id',0);$comment=(new Comment($this->pdo()))->findDetailed($id);if(!$comment)Response::abort(404,'Không tìm thấy bình luận.');$csrfToken=csrfToken();$this->render('admin.comments.detail',compact('comment','csrfToken'));}
    public function moderateJson(Request $r):void{$this->auth->requireRole(['admin']);if(!$r->isPost())Response::json(['success'=>false,'message'=>'Phương thức không được phép.'],405);verifyCsrf();$id=(int)$r->input('comment_id',0);if($id<=0)Response::json(['success'=>false,'message'=>'ID bình luận không hợp lệ.'],400);$model=new Comment($this->pdo());$action=(string)$r->input('action','');if($action==='delete'){$ok=$model->delete($id);Response::json(['success'=>$ok,'message'=>$ok?'Xóa bình luận thành công.':'Không thể xóa bình luận.'],$ok?200:500);} $status=(string)$r->input('status','');if(!in_array($status,['approved','hidden'],true))Response::json(['success'=>false,'message'=>'Trạng thái không hợp lệ.'],400);$ok=$model->updateStatus($id,$status);$messages=['hide'=>'Ẩn bình luận thành công.','show'=>'Hiển thị bình luận thành công.','approve'=>'Duyệt bình luận thành công.'];Response::json(['success'=>$ok,'message'=>$ok?($messages[$action]??'Cập nhật trạng thái bình luận thành công.'):'Không thể cập nhật trạng thái bình luận.','status'=>$status],$ok?200:500);}
    private function pdo():PDO{return ($this->pdoFactory)();}
}
