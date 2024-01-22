<h1 >Welcome </h1>
<br>
<div class="d-flex justify-content-between">
    <a href="http://localhost/clones/phptest/create" type="button" class="btn btn-success">create</a>
    <a href="http://localhost/clones/phptest/update" type="button" class="btn btn-primary">update</a>
    <button onclick="truncate()" type="button" class="btn btn-danger">truncate</button>
</div>
<br>
<table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">name</th>
      <th scope="col">email</th>
      <th scope="col">password</th>
      <th scope="col">gender</th>
      <th scope="col">hobby</th>
      <th scope="col">img</th>
      <th scope="col">delete</th>
    </tr>
  </thead>
  <tbody id="tbody">
  
  </tbody>

  <script>
  
       
    $(document).ready(function(){
      let url = "http://localhost/clones/phptest/getusers";
      jQuery.ajax({
        url:url,
        type:'GET',
        cache:false,
        contentType:false,
        processData:false,
        success:function(result){
            result = JSON.parse(result);
            console.log(Array.isArray(result));
            console.log(result);
            result.forEach(e => {
            $('#tbody').append(`
            <tr>
            <th scope="row">${e.id}</th>
            <td>${e.userName}</td>
            <td>${e.userEmail}</td>
            <td>${e.userPassword}</td>
            <td>${e.userGender}</td>
            <td>${e.userHobby}</td>
            <td><img src="${e.userImage}" alt="IMG" width="50px" height="50px"></td>
            <td><button type="button" id="delete_btn" onclick="delete_(this)" class="btn btn-danger" value="${e.id}">❌</button></td>
            </tr>
            `);
            });
            
        }
      });
   
    });

    function truncate(){
      $(document).ready(function(){
        let url = "http://localhost/clones/phptest/truncate";
        jQuery.ajax({
          url:url,
          type:'GET',
          cache:false,
          processData:false,
          contentType:false,
          success:function(result){
            // console.log(result);
            if(result){
              window.location.reload();
            }
          }
        })
      });
    } 
    
    function delete_ (e){ 
        $(document).ready(function(){
        // e.preventDefault();
        let url="http://localhost/clones/phptest/delete?id="+$('#delete_btn').val();
        jQuery.ajax({
          url:url,
          type:'GET',
          cache:false,
          processData:false,
          contentType:false,
          success:function(result){
            let data = JSON.parse(result);
            console.log(data);
            if(data == true){
              window.location.reload();
            }
          }
        });
      });
      }
  </script>