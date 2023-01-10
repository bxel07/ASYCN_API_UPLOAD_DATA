 const fileInput = document.getElementById("file");
 let myFiles = {};


 let isFilesReady = true;

 fileInput.addEventListener("change", async (event) => {
   myFiles = {};
   isFilesReady = false;

   const inputKey = fileInput.getAttribute("name");
   var files = event.srcElement.files;

   const filePromises = Object.entries(files).map((item) => {
     return new Promise((resolve, reject) => {
       const [index, file] = item;
       const reader = new FileReader();
       reader.readAsBinaryString(file);

       reader.onload = function (event) {
         const fileKey = `${inputKey}${
           files.length > 1 ? `[${index}]` : ""
         }`;
         myFiles[fileKey] = `${file.type};base64,${btoa(
           event.target.result
         )}`;

         resolve();
       };
       reader.onerror = function () {
         console.log("can't read the file");
         reject();
       };

     });
   });

   Promise.all(filePromises)
     .then(() => {
       console.log("ready to submit");
       isFilesReady = true;
     })
     .catch((error) => {
       console.log(error);
       console.log("something wrong happened");
     });
 });

 const formElement = document.getElementById("form");

 const handleForm = async (event) => {
   event.preventDefault();

   if (!isFilesReady) {
     console.log("files still getting processed");
     return;
   }

   const formData = new FormData(formElement);

   let data = {
     kategori: formData.get("kategori"),
     tag: formData.get("tag")
   };

   Object.entries(myFiles).map((item) => {
     const [key, file] = item;
     data[key] = file;
   });

 
   fetch("controller/controller.co.php", {
   method: "POST",
   body: JSON.stringify(data),
   headers: {
        "Content-Type": "application/json",
        Accept: "application/json"
      }
    })
      .then((r) => r.text())
      .then((res) => {
        console.log(res);
      });
 };

 formElement.addEventListener("submit", handleForm);