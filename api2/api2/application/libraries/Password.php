<?php
class Password {
	public $Text;
	public $Hash;
	public $Salt = "Go Helps ~ The Charity Project (c) 2016";

	function encrypt($text=''){
		$this->Text = ($text)?$text:$this->Text;
		$this->mypwd();
		return $this->Hash;
	}

	function mypwd(){
		$hash = array(
			0=>"0x4F",
			1=>"0x3C",
			2=>"0x5D",
			3=>"0x4C",
			4=>"0x9B",
			5=>"0x7E",
			6=>"0x8E",
			7=>"0x6F",
			8=>"0x3A",
			9=>"0x8A",
			"A"=>"0x16",
			"B"=>"0x45",
			"C"=>"0xAF",
			"D"=>"0x0A",
			"E"=>"0xC4",
			"F"=>"0x90"
		);

		$this->Hash = md5($this->Text.$Salt);
		$this->Hash = sha1($this->Hash);
		$this->Hash = strrev($this->Hash);
		$this->Hash = md5($this->Hash);
		$this->Hash = base64_decode($this->Hash);
		$this->Hash = sha1($this->Hash);
		$this->Hash = strrev($this->Hash);
		$this->Hash = substr($this->Hash,0,20);

		for($i=0;$i<strlen($this->Hash);$i++){
			$char = strtoupper(substr($this->Hash,$i,1));
			$mypwd .= "/".$hash[$char];
		}

		$this->Hash = $mypwd;
	}
}
?>
