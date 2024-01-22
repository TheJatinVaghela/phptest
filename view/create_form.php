
<form action="http://localhost/clones/phptest/adduser" method="POST" enctype="multipart/form-data" id="create">
    <div class="mb-3">
        <label for="userName" class="form-label">Name</label>
        <input type="text" name="userName" class="form-control" id="userName" aria-describedby="nameHelp" required>
        <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
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
    <div class="mb-3">
        <label for="userImage" class="form-label">Default file input example</label>
        <input class="form-control" accept="img/*" name="userImage" type="file" id="userImage" required>
    </div>
    <label for="exampleInputGender1" class="form-label mt-3">Gender</label>
    <div class="d-flex justify-content-start">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userGender" id="userGender_male" value="male">
            <label class="form-check-label" for="userGender_male">male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userGender" id="userGender_female" value="female">
            <label class="form-check-label" for="userGender_female">female</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userGender" id="userGender_other" value="other">
            <label class="form-check-label" for="userGender_other">other</label>
        </div>
    </div>
    <label for="exampleInputGender1" class="form-label mt-3">Hobby</label>
    <div class="d-flex justify-content-start mb-3">
        <select id="inputState" name="userHobby" class="form-select" required>
            <option id="userHobby_baseboll" value="baseboll">baseboll</option>
            <option id="userHobby_chess" value="chess">chess</option>
            <option id="userHobby_footboll" value="footboll">footboll</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    $(document).ready(function(){
        $('#create').on("submit",function(e){
            e.preventDefault();
            let url = "http://localhost/clones/phptest/adduser";
            let formData = new FormData(this);
            jQuery.ajax({
                url: url,
                data:formData,
                type:"POST",
                cache: false,
                contentType: false,
                processData: false,
                success:function(result){
                    let data = JSON.parse(result);
                    console.log(data);
                    if(data == true){
                        window.location.replace("http://localhost/clones/phptest/home");
                    }
                }
            });
        });
    });
</script>