<?php
/**
 * db table iterate
 * author: postor@gmail.com
 */
namespace postor\dbtableiterate;

use yii\db\ActiveQuery;

use Yii;

class DbTableIterate {
	
	private $_offset;
	private $_limit;
	private $_query;
	private $_pageSize;
	private $_current;
	private $_callback;
		
	/**
	 * 构造函数，请在query中设置好order
	 * @param ActiveQuery $query
	 * @param int $pageSize
	 */
	function __construct($query, $callback, $pageSize = 1000) {
  	$this->_query = $query;
  	$this->_callback = $callback;
  	$this->_pageSize = $pageSize;
  	$this->_current = $this->_offset = $query->offset;
  	$this->_limit = $query->limit;
  	$this->iterate($callback);
	}
	
	/**
	 * 遍历
	 * @param function $callback
	 */
	private function iterate($callback){
		while(true){
			$limit = $this->_pageSize;
			if($this->_limit){
				//存在限制的情况
				$left = ($this->_offset + $this->_limit) - ($this->_current + $this->_pageSize);
				if($left<0){
					$limit = $this->_pageSize + $left;
					$this->runList($this->_current, $limit,$callback);
					break;
				}elseif($left === 0){					
					$this->runList($this->_current, $limit,$callback);
					break;
				}else{					
					$this->runList($this->_current, $limit,$callback);
					$this->_current += $this->_pageSize;					
				}
			}else{
				//不存在限制的情况
				if($this->runList($this->_current, $limit,$callback)<$this->_pageSize){
					break;
				}else{					
					$this->_current += $this->_pageSize;
				}
			}
		}
		
		
		
	}
	
	private function runList($offset,$limit,$callback){		
		$this->_query->offset($offset);
		$this->_query->limit($limit);
		$list = $this->_query->all();
		foreach($list as $row){
			$callback($row);
		}
		return count($list);
	}
}