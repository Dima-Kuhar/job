<?php


Class Forum
{
    public $attributes = array();
    public $errors = array();

    public function __construct() {
        //$this->getAttributes();
    }

    public function sendUserMessage($from,$to,$mes) {
        mysql_query("INSERT INTO forum_user_msg SET `from`='".$from."',`to`='".$to."',`date`='NOW()',`msg`='".$mes."'");
    }

    public function sendCabs($from,$to,$sum,$code=3) {
        
    	// �������� � �����������
		$q = " INSERT INTO cabs_flow (id,f_uid,sum,`when`,usl) VALUES ('','".$from."','-".$sum."',NOW(),".$code." ) ";
		//echo $q.'<br>';
		mysql_query($q);

		// ���������� �����
		$q = " INSERT INTO cabs_flow (id,f_uid,sum,`when`,usl) VALUES ('','".$to."','".$sum."',NOW(),".$code." ) ";
		//echo $q.'<br>';
		mysql_query($q);

		// ��������� ���������� � �����
		$q = " UPDATE cabs_state SET amount = amount +  ".$sum." WHERE f_uid = ".$to." LIMIT 1 ";
		//echo $q.'<br>';
		mysql_query($q);

		// ��������� ���������� � �����������
		$q = " UPDATE cabs_state SET amount = amount -  ".$sum." WHERE f_uid = ".$from." LIMIT 1 ";
		//echo $q.'<br>';
		mysql_query($q);

		// ��������� �������
		$q = " INSERT INTO cabs_f_perevod (id,cfrom,cto,chowmany,cwhen) VALUES ('','".$from."',".$to.",'".$sum."',NOW() ) ";
		//echo $q.'<br>';
		mysql_query($q);
		$perevod_id = mysql_insert_id();
		
		return $perevod_id;
    }

    public function sendAdminMessage($to,$mes) {
        
        // ����� ���� ���������
        $q = "INSERT INTO forum_adm_msg SET text='".mysql_real_escape_string($mes)."', date=NOW()";
    	mysql_query($q);
        $mess_id=mysql_insert_id();

        // ������ � ����� ������������ �� �������� "�� ���������"
        $q = "INSERT INTO forum_adm_to_usr ( f_uid,mess_id,`read` ) VALUES ( ".$to.",".$mess_id.",0) " ;
		mysql_query($q);
		//echo mysql_error();
               
		return $mess_id;
    }

    // ������ ����� ����
    // $area=6 ��� �������� �����
    public function createPost($from,$title,$mes,$area=6,$topic_id=0) {
        
        // ���� � ����
    	if ( $topic_id ) { 
 			
    		$q = "INSERT INTO forum_tree SET uid='".$from."', area='".$area."', topic_id = '".$topic_id."' , parent = '".$topic_id."', title='".$title."', date=NOW(), ip='".$_SERVER['REMOTE_ADDR']."'";
			//echo $q."<br>"; 
			mysql_query($q);
			$post_id=mysql_insert_id();

			$q = "INSERT INTO forum_msg_body SET postid='".$post_id."',message='".$mes."'";
			//echo $q."<br>"; 
			mysql_query($q);

    	} else { // ����� ����

	        // ����� ����
	        $q = "INSERT INTO forum_tree SET uid='".$from."', area='".$area."', title='".$title."', date=NOW(), ip='".$_SERVER['REMOTE_ADDR']."'";
			//echo $q."<br>"; 
			mysql_query($q);

			$post_id=mysql_insert_id();

			$q = "UPDATE forum_tree SET topic_id='".$post_id."' WHERE postid='".$post_id."'";
			//echo $q."<br>"; 
			mysql_query($q);

			$q = "INSERT INTO forum_msg_body SET postid='".$post_id."',message='".$mes."'";
			//echo $q."<br>"; 
			mysql_query($q);
		}

		return $post_id;
    }

     // ������ �������������� � ����
    public function setDecor($post_id,$decor) {
    	$q = "UPDATE forum_tree SET decor='".$decor."' WHERE postid='".$post_id."' LIMIT 1";
		//echo $q."<br>"; 
		mysql_query($q);
    }


}

?>