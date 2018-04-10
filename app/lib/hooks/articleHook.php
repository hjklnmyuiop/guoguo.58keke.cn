<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/29 0029
 * Time: 上午 10:05
 */

namespace lib\hooks;

use lib\models\Article;
use Yii;

class articleHook extends \lib\hooks\basicHook
{

	/**
	 * 找回密码
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number string
	 */
	public function articlelist()
	{
		$search = $this->get('search');
		$id = $this->get('id');
		$where  = 'status=1';
		if (!empty($id))
		{
			$where .= " and cate_id  = " . $id ;
		}
		if (!empty($search['keyword']))
		{
			$where .= " and title  like '%" . $search['keyword'] . "%'";
		}
		$order = 'id desc';
		if(isset($search['sort']) && !empty($search['sort']) &&$search['sort']=='hot' ) $order = 'clicknum desc ';
		$article_model =  new Article();
		$count = $article_model->find()->where($where)->count();
		$goodsList = $article_model->find()->select(['id','title','clicknum','create_time','collect','thumb','content'])->where($where)
				->orderBy('create_time desc')
				->all();
		if(is_array($goodsList)){
			foreach($goodsList as $key=> &$value){
				$value->create_time =date('Y-m-d',$value->create_time);
			}
		}
		$this->retData['count'] = $count;
		$this->retData['items'] = $goodsList;
		return $this->retData;
	}
	/**
	 * 资讯详情页
	 */
	public function detail()
	{
		$id = (int)$this->get('id', '');
		$article_model =  new Article();
		$article = $article_model->findOne(['id' => $id,'status'=>1]);
		if($article){
			$newsData['content'] =strip_tags($article->content);
			$newsData['create_time'] =date('Y-m-d',$article->create_time);
			$newsData['user_head'] = $article->user->head;
			$newsData['title'] = $article->title;
			$newsData['thumb'] = $article->thumb;
			$newsData['clicknum'] = $article->clicknum;
			$newsData['collect'] = $article->collect;
		}
		$this->retData['detail'] = $this->retData['detail'] = $this->array2object($newsData);
		return $this->retData;
	}
}