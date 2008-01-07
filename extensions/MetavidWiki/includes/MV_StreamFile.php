<?php
/*
 * MV_StreamFiles.php Created on Sep 25, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 
 /*
  * MvStreamFile hanndles the mapping of path types to urls & 
  * active record style management of the mv_stream_files table
  */
 
 class MV_StreamFile{
 	var $stream_id='';
 	var $base_offset='';//base offset from the stream  date_start_time
 	var $duration='';	//duration of clip.
 	var $file_desc_msg='';
 	var $path='';
 	
 	function __construct(&$parent_stream, $initRow=''){
 		$this->parent_stream =& $parent_stream;
 		//no init val.. popluate from db 		 	
 		if($this->parent_stream && $initRow==''){
 			$this->getStreamFileDB();
 		}else{		 
 			//populate from the initRow obj
			if (is_object($initRow))
				$initRow = get_object_vars($initRow);
			if (is_array($initRow)) {
				foreach ($initRow as $key => $val) {
					//make sure the key exisit and is not private
					if (isset ($this-> $key) && $key[0] != '_') {
						$this->$key = $val;
					}
				}
			}
 		}
 	}
 	function getStreamFileDB($quality=null){
		global $mvDefaultVideoQualityId, $mvStreamFiles;
		if($quality==null)$quality=$mvDefaultVideoQualityId;
		$dbr = & wfGetDB(DB_READ);
		$result = $dbr->select($dbr->tableName($mvStreamFiles), array('path'), array (			
			'stream_id' => $this->parent_stream->getStreamId(),
			'file_desc_msg'=>$quality
		));
		$row  =$dbr->fetchObject($result);
		if($row){
			$ary = get_object_vars($row);
			foreach($ary as $k=>$v){
				$this->$k=$v;
			}	
		}	
	}
	//@@todo as mentioned before we should better integrate with medaiWikis commons file system
	//returns the local path (if the video file is local) if not return null 
	function getLocalPath($quality=null){
		global $mvLocalVideoLoc,$mvDefaultVideoQualityId;
		if($quality==null)$quality=$mvDefaultVideoQualityId;
		
		if(!is_dir($mvLocalVideoLoc))return null;
		if(!is_file($mvLocalVideoLoc . $this->parent_stream->getStreamName() ))return null;
		//all looks good return: 		
		return $mvLocalVideoLoc . $this->parent_stream->getStreamName();		
	}
 	/*
 	 * returns the path with {sn} replaced with stream name if present
 	 */
 	function getPath(){
 		return $this->path;
 		//return str_replace('{sn}',$this->parent_stream->name, $this->path);
 	}
 	function get_link(){ 		
 		global $mvVideoArchivePaths;
 		return $this->getPath();
 		/*if(isset($mvVideoArchivePaths[ $this->path_type ] )){
 			//we can return the link
 			return $mvVideoArchivePaths[ $this->path_type ] . $this->getPath();
 		}else{
 			if($this->path_type=='ext_url'){
 				return $this->getPath();
 			}
 		}
 		return null;	*/
 	}
 	function get_desc(){
 		return $this->file_desc_msg;
 	}
 }
?>
