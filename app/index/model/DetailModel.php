<?php
namespace index\model;

use vendor\Model;

use vendor\Page;

class DetailModel extends Model
{
	//首页数据

	function search($where = null)
	{
		if ($where == null) {
			return $this->where("cid!=''")->select();
		} else {
			return $this->where("id=" . $where)->select();
		}
	}

	function searc()
	{
		return $this->select();
	}

	function articalCount($where = null)
	{
		if ($where == null) {
			$result = $this->field('id')->where("cid='' and rid='' and istrash=0")->select();
		} else {
			$result = $this->where('istrash=0 and ' . $where)->field('id')->select();
		}
		return count($result);		
	}

	function page()
	{
		$page = new Page(2,$this->articalCount());	
		return $allPage = $page->allPage();		
	}

	function lastlimit($where = null)
	{

		$page = new Page(2,$this->articalCount($where));
		$limit = $page->limit();	
		if ($where == null) {
			$result = $this->limit($limit)->order('id desc')->where("rid='' and cid=0 and istrash=0 ")->select();
		} else {
			$result = $this->where('istrash=0 and '.$where)->limit($limit)->order('id desc')->select();
		}
		return $result;
	}

	//detail页面信息
	function artical($where)
	{
		$result = $this->where('id=' . $where)->select();
		return $result;
	}

	//评论数量统计
	function commentnumber($data)
	{
		$id = $this->field('id')->where('rid=' . $data)->select();
		if (empty($id)) {
			$number = 0;
		} else {
			$number = count($id);
		}
		//更新评论数量
		$this->where('id=' . $data)->update(['replaynumber' => $number]);
		return $number;
	}

	//设置置顶
	function istop($id)
	{
		$this->update(['istop' => 0]);
		$this->where('id=' . $id)->update(['istop' => 1]);
	}

	//取消置顶
	function canceltop()
	{
		$this->update(['istop' => 0]);
	}

	//查询关键字
	function selectCategory()
	{
		return $this->field('category,cid')->where('cid!=0')->select();
	}

	//浏览数量增加
	function addhit($data)
	{
		$hit = $this->field('hit')->where('id=' . $data)->select();
		$hit = $hit[0]['hit'] + 1;
		$this->where('id=' . $data)->update(['hit' => $hit]);
	}

	//查询回复信息
	function replay($data)
	{
		return $this->field('replay,posttime,postname')->where('rid=' . $data)->select();
	}

	//增加评论
	function addreplay($id,$name,$content)
	{
		$this->insert(['rid' => $id,'postname' => $name,'replay' => $content]);
	}

	//增加文章内容
	function addartical($title,$content,$category,$cid,$name)
	{
		return $this->insert([
			'title' => $title, 
			'content' => $content, 
			'category' => $category, 
			'tid' => $cid, 
			'postname' => $name
		]);
	}

	//加入版块信息
	function addmodule($name,$cid)
	{
		$this->insert(['category' => $name, 'cid' => $cid]);
	}

	//删除板块
	function deletemodule($id,$cid)
	{
		$this->where('id=' . $id)->delete();
		$this->where('tid=' . $cid)->delete();
	}

	//查询博文
	function blogs()
	{
		return $this->where('tid!=\'\'')->select();
	}

	//删除博文
	function deleteblogs($data)
	{
		if (!empty($data)) {
			foreach ($data as $value) {
				$this->where('id=' . $value)->delete();
				$this->where('rid=' . $value)->delete();
			}
		}
	}

	//读取评论信息
	function readcomment()
	{
		$result = $this->where('rid!=\'\'')->select();
		$i = 0;
		foreach ($result as $value) {
			$res = $this->field('title')->where('id=' . $value['rid'])->select();
			$result[$i++]['title'] = $res[0]['title'];
		}
		return $result;
	}

	//删除评论
	function deletecomment($data)
	{
		if (!empty($data)) {
			foreach($data as $value) {
				$this->where('id=' . $value)->delete();
			}
		}
	}

	
}




