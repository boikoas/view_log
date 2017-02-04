<?php
  
class FileReader
{
   protected $handler = null;
   protected $fbuffer = array();
 
   public function __construct($filename)
   {
       if(!($this->handler = fopen($filename, "rb")))
       throw new Exception("Cannot open the file");
   }
 
   public function Read()
   {
       if(!$this->handler)
            throw new Exception("Invalid file pointer");
 
       while(!feof($this->handler))
       {
            $this->fbuffer[] = fgets($this->handler);
            
       }
 
       return $this->fbuffer;
    }
 
    public function SetOffset()
    {
        if(!$this->handler)
            throw new Exception("Invalid file pointer");
 
        while(!feof($this->handler)) {
             fgets($this->handler);
        }
     }
     
}