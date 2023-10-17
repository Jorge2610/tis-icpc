function handleImageUpload() {
    document.getElementById('uploadButton').style.display = 'none';
    document.getElementById('uploadIcon').style.display = 'none';
    document.getElementById('imagePreview').style.display = 'block';
  
    var reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('imagePreview').src = e.target.result;
    }
    reader.readAsDataURL(document.getElementById('imageUpload').files[0]);
  }