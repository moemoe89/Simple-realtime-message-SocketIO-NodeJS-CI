<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Realtime Message</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
  </head>
  <style>
  body { padding-top: 70px; }
  
  #load { height: 100%; width: 100%; }
  #load {
    position    : fixed;
    z-index     : 99999; /* or higher if necessary */
    top         : 0;
    left        : 0;
    overflow    : hidden;
    text-indent : 100%;
    font-size   : 0;
    opacity     : 0.6;
    background  : #E0E0E0  url(<?php echo base_url('assets/images/load.gif');?>) center no-repeat;
  }
  
  .RbtnMargin { margin-left: 5px; }
  
  
  </style>
  <body>
    <div id="load">Please wait ...</div>

<nav class="navbar navbar-default navbar-fixed-top " role="navigation">
  <div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url();?>">Simple Realtime Message</a>
  </div>
  </div>
</nav>
    
<center><a href="<?php echo site_url('message');?>">Click here to see the list message</a></center><br />
<div class="container">
  <div class="row">
    <div id="notif"></div>
      <div class="col-md-6 col-md-offset-3">
        <div class="well well-sm">
          <form class="form-horizontal">
          <fieldset>
            <legend class="text-center">Contact us</legend>
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Name</label>
              <div class="col-md-9">
                <input id="name" type="text" placeholder="Your name" class="form-control" autofocus>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="email">E-mail</label>
              <div class="col-md-9">
                <input id="email" type="email" placeholder="Your email" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="subject">Subject</label>
              <div class="col-md-9">
                <input id="subject" type="text" placeholder="Your subject" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="message">Your message</label>
              <div class="col-md-9">
                <textarea class="form-control" id="message" name="message" placeholder="Please enter your message here..." rows="5"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="button" id="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
  </div>
</div>

<hr>
<footer class="text-center">Simple Realtime Message &copy 2015</footer>
<hr>

  <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
	<script>
  $(document).ready(function(){

		$("#load").hide();

    $("#submit").click(function(){
      
      $( "#load" ).show();

       var dataString = { 
              name : $("#name").val(),
              email : $("#email").val(),
              subject : $("#subject").val(),
              message : $("#message").val()
            };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('send/submit');?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){

              $( "#load" ).hide();
              $("#name").val('');
              $("#email").val('');
              $("#subject").val('');
              $("#message").val('');

              if(data.success == true){

                $("#notif").html(data.notif);

                var socket = io.connect( 'http://'+window.location.hostname+':3000' );

                socket.emit('new_count_message', { 
                  new_count_message: data.new_count_message
                });

                socket.emit('new_message', { 
                  name: data.name,
                  email: data.email,
                  subject: data.subject,
                  created_at: data.created_at,
                  id: data.id
                });

              } else if(data.success == false){

                $("#name").val(data.name);
                $("#email").val(data.email);
                $("#subject").val(data.subject);
                $("#message").val(data.message);
                $("#notif").html(data.notif);

              }
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });

    });

  });
	</script>
  </body>
</html>