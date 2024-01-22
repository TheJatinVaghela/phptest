


<h1 >UPDATE </h1>

<div class="d-flex justify-content-start mb-3" id="userIdSelect_wrapper">
    <select id="userIdSelect" name="userHobby" class="form-select" required>
    </select>
</div>

<h1>UPDATE FORM</h1>
<br>
<form action="http://localhost/clones/phptest/updateUser" method="POST" enctype="multipart/form-data" id="update">
    <div class="mb-3">
        <label for="userName" class="form-label">Name</label>
        <input type="text" name="userName" class="form-control" id="userName" aria-describedby="nameHelp" required>
        <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
    </div>
    <div class="mb-3" id="id_wrapper">
        <label for="id" class="form-label">id</label>
        <input type="text" name="id" class="form-control" id="id" aria-describedby="idHelp">
        <div id="idHelp" class="form-text">We'll never share your name with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="userEmail" class="form-label">Email address</label>
        <input type="email" name="userEmail" class="form-control" id="userEmail" aria-describedby="emailHelp" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="userPassword" class="form-label">Password</label>
        <input type="password" name="userPassword" class="form-control" id="userPassword" required>
    </div>
    <div class="mb-3" id="showUserImage_wrapper">
        <img id="showUserImage" src="" alt="IMG" width="50px" height="50px">
        <button id="delete_ShowImage">❌</button>
    </div>
    <div class="mb-3" id="userImage_wrapper">
        <label for="userImage" class="form-label">Default file input example</label>
        <input class="form-control" accept="img/*" name="userImage" type="file" id="userImage" >
        <button id="delete_AddImage">❌</button>
    </div>
    <label for="exampleInputGender1" class="form-label mt-3">Gender</label>
    <div class="d-flex justify-content-start">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userGender" id="male" value="male">
            <label class="form-check-label" for="userGender_male">male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userGender" id="female" value="female">
            <label class="form-check-label" for="userGender_female">female</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userGender" id="other" value="other">
            <label class="form-check-label" for="userGender_other">other</label>
        </div>
    </div>
    <label for="exampleInputGender1" class="form-label mt-3">Hobby</label>
    <div class="d-flex justify-content-start mb-3">
        <select id="inputState" name="userHobby" class="form-select" required>
            <option id="baseboll" value="baseboll">baseboll</option>
            <option id="chess" value="chess">chess</option>
            <option id="footboll" value="footboll">footboll</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">update</button>
</form>


<script>
    $(document).ready(function(){
        $('#update').css('display','none');
        $('#id_wrapper').css('display','none');
        $('#userImage_wrapper').css('display','none');

        // GET ALL USER ID SO ADMIN CAN SELECT ID TO UPDATE INFO
        let url = "http://localhost/clones/phptest/getusers";
        jQuery.ajax({
            url:url,
            type:'GET',
            cache:false,
            contentType:false,
            processData:false,
            success:function(result){
                result = JSON.parse(result);
                result.forEach(e => {
                    // console.log(e.id);
                    $('#userIdSelect').append(`<option id='${e.id}' value='${e.id}'>${e.id}</option>`);
                })
            }
        });

        //GET THE INFO OF SELECTED ID BY ADMIN AND SHOW THE DETAILS TO THE UPDATE FORM
        $("#userIdSelect_wrapper").mouseup(function(e){
            console.log("mouse leave");
            console.log($('#userIdSelect').val());
            let url = `http://localhost/clones/phptest/getusers?id=${$('#userIdSelect').val()}`;
            jQuery.ajax({
                url:url,
                type:'GET',
                cache:false,
                contentType:false,
                processData:false,
                success:function(result){
                    result = JSON.parse(result);
                    console.log(result);
                    $('#update').css('display','block'); 
                    $('#id').val(result[0].id);
                    $('#userName').val(result[0].userName);
                    $('#userEmail').val(result[0].userEmail);
                    $('#userPassword').val(result[0].userPassword);
                    $('#showUserImage').attr('src',result[0].userImage);
                    $(`#${result[0].userHobby}`).attr('selected',true);
                    $(`#${result[0].userGender}`).attr('checked',true);
                }
            });
        });

        //DELETE IMG SO USER CAN ADD NEW ONE
        $('#delete_ShowImage').click(function(e){
            e.preventDefault();
            $('#showUserImage_wrapper').css('display','none');
            $('#userImage_wrapper').css('display','block');
        });

        //IF ADMIN DO NOT WATN TO CHANGE IMG THEN DO THIS
        $('#delete_AddImage').click(function(e){
            e.preventDefault();
            $('#userImage_wrapper').css('display','none');
            $('#showUserImage_wrapper').css('display','block');
        });

        //IF ADMIN CLICK UPDATE 
        $('#update').on('submit',function(e){
            e.preventDefault();
            
            let fd = new FormData(this);
            let url = "http://localhost/clones/phptest/updateUser";
            jQuery.ajax({
                url:url,
                data:fd,
                type:'POST',
                cache:false,
                processData:false,
                contentType:false,
                success:function(result){
                    let data = JSON.parse(result);
                    console.log(data); 
                    if(data == true){
                        window.location.replace("http://localhost/clones/phptest/home");
                    }
                }
            })
        });
    });
</script>