<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>EMAIL ADDRESS</h4>
                    <br/>
                    <label>Your email address</label>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <button onclick="SentOTP()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   async function SentOTP() {
 try{
    let email= document.getElementById("email").value;
    // window.alert(email);
   let res =await axios.post("/send-otp",
   { email:email});
   if(res.status===200 && res["data"]["status"]=="sucessful")
   {
    sessionStorage.setItem("email",email)
    window.location.href="/verifyotp";
   }
   else{
    window.alert(JSON.stringify(res))
   }
}
   catch(e)
   {
    window.alert(e)
   }
 }
</script>
