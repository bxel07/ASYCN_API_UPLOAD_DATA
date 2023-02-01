<?php 
    class controller_xel{
        //data text
        protected $kategori;
        protected $tag;

        //Informasi gambar
        protected $name;
        //raw image size
        protected $size;
        //categorized image size
        protected $actsize;


        protected $ext;
        protected $allow = ['jpg', 'jpeg', 'png', 'svg'];

        //untuk proses menampung encode data dan decode data
        protected $enc;
        protected $dec;
        protected $bin;

        //flag
        protected $flag = true;

        
        public function __construct(){
            $this->start();
        }

        protected function getterdata() {
            $grab = file_get_contents('php://input',true);
            $decode = json_decode($grab);
            $this->kategori = $decode->kategori;
            $this->tag = $decode->tag;
            $this->enc = $decode->file;
        }

        public function decode() {
            //getting extension & binary(decode)
            if(preg_match("/^image\/(\w+);base64,/",$this->enc,$match)){
                $this->ext = $match[1];
                $pattern = $match[0];
                
                //getting binnary
                $this->bin = str_replace($pattern,"",$this->enc);

                $this->dec = base64_decode($this->bin);

            }
        }

        public function convertbyte() {
            $tmpsize = strlen($this->dec);
            
            if($tmpsize != null) {
                $this->size = round($tmpsize / 1024);
            }

          if($this->size < 1024){
            $this->actsize = "{$this->size} KB";
          } else {
            $this->actsize = "{$this->size} MB";
          }
          
        }

        public function validate() {

            $this->flag = false;

            if(in_array($this->ext, $this->allow)){
                if($this->size < 10240) {
                    $this->name = uniqid().".".$this->ext;
                    $this->flag = true;
                }
            }
        }

        public function upload() {
            if($this->flag != true){
                echo "something wrong with validate";
            }

            $path = dirname(__FILE__,2)."\\model\\write.json";
            $dest = dirname(__FILE__,2)."\\model\\upload\\{$this->name}";
            $file = file_get_contents($path);
            $decode = json_decode($file,true);
            $inc = 1;
            // save to database
            if(empty($decode[0])) {
                $data = array (
                        "kategori" => $this->kategori,
                        "tag" => $this->tag,
                        "image" => $this->name
                );
            }
            //for json 
            /* if(empty($decode[0])) {

                $data = array(
                    array(
                        "id" => $inc,
                        "kategori" => $this->kategori,
                        "tag" => $this->tag,
                        "image" => $this->name
                    )
                   
                );

                $encode = json_encode($data,JSON_PRETTY_PRINT,JSON_FORCE_OBJECT);
                file_put_contents($path,$encode);
                file_put_contents($dest,$this->dec);
                echo "data berhasil di tambahkan";

            } else {
                $last_item = end($decode);
                $last_id = $last_item['id'];
                $data = array(
                        "id" => ++$last_id,
                        "kategori" => $this->kategori,
                        "tag" => $this->tag,
                        "image" => $this->name 
                );

                array_push($decode, $data);
                $encode = json_encode($decode,JSON_PRETTY_PRINT);
                file_put_contents($path,$encode);
                file_put_contents($dest,$this->dec);
                echo "data berhasil di tambahkan"; 

            } */
        }

        public function start() {
            $this->getterdata();
            $this->decode();
            $this->convertbyte();
            $this->validate();
            $this->upload();
        }
    }

    $obj = new controller_xel();

?>