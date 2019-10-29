<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>


</head>
<body>
<div class="container" id="app">
    <div class="row">
        <div class="col-md-6 offset-3 mt-4">
            <div class="card">
                <div class="card-header"><h3 class="text-center">Login</h3></div>
                <div class="card-body">
                    <form method="post" id="form" @submit.prevent = "authorization" v-if="!auth">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Login</label>
                            <input type="text" class="form-control" name="login" id="login" placeholder="Login"
                                   required v-model ="login">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                                   required v-model ="password">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" v-if="message"  v-model="message" disabled id="inputError">
                        </div>
                        <div class="form-group right">
                            <button class="btn btn-success " style="float: right" >Login</button>
                        </div>
                    </form>
                    <div class="col-md-12" v-if="auth">
                        <div class="form-group">
                            <input type="text" class="form-control" v-if="message" id="inputSuccess" v-model ="message" disabled>
                        </div>
                        <button class="btn btn-danger" @click="logOut">Log out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    var app = new Vue({
        el: '#app',
        data(){
            return {
                form: false,
                login: '',
                password: '',
                auth: false,
                message: ''
            }
        },
        created(){
             if( localStorage.getItem('token')){
                 this.auth = true;

             }
        },
        methods: {
            logOut(){

                var formdata = new FormData();
                var login =  this.login;
                var password =  this.password;
                formdata.append('jsonrpc','2.0');
                formdata.append('method','Session_logout');
                formdata.append('id',Math.floor(Math.random() * 100) + 1);
                formdata.append('params',[localStorage.getItem('token')]);

                axios.post('http://127.0.0.1:81',formdata).then((resp)=>{
                    localStorage.clear();
                    location.reload();
                }).catch (()=>{})

            },
            authorization(){


                var formdata = new FormData();
                var login =  this.login;
                var password =  this.password;
                formdata.append('jsonrpc','2.0');
                formdata.append('method','Session_login');
                formdata.append('id',Math.floor(Math.random() * 100) + 1);
                formdata.append('params',[login,password]);

                axios.post('http://127.0.0.1:81',formdata).then((resp)=>{
                    if(resp.data.result){
                        this.auth = true;
                        localStorage.setItem('token',resp.data.result);
                        this.message = 'успешная авторизация';
                    }


                }).catch (()=>{
                    this.auth = false;
                    this.message = 'неверный логин или пароль';

                })
            }
        }

    })


</script>

</body>
</html>
