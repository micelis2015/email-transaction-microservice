<template>
  <div id="container" class="container">
    <h2>UserMail Admin UI</h2>
	<div id="send_mail" class="container rounded border">
	    <h2>Send email</h2>
	    <form>
	    <div class="form-group">
		<div class="row">
		  <div class="col">
		    <label for="uid">User ID</label>
		    <input id="uid" class="form-control" value="1" type="text" ></input>
		  </div>
		  <div class="col">
		    <label for="mtid">Email type</label>
		    <select id="mtid" class="form-control">
			<option value="1">HTML</option>
			<option value="2">MarkDown</option>
			<option value="3">Plain Text</option>
		      </select>
		    </div>
		</div>
	    </div>  
	    <div class="form-group">
		<label for="mail_to">Email address(es)</label>
		<input id="mail_to" class="form-control" type="email" value="trythis@example.com, anothermail@example.com" ></input>
	    </div>
	    <div class="form-group">
		<label for="subject">Subject</label>
		<input id="subject" class="form-control" type="text" value="This is a email" ></input>
	    </div>
	    <div class="form-group">
		<label for="content">Content</label>
		<textarea id="content" class="form-control" rows="3" ></textarea>
	     </div>
	     </form>
	</div>
	<div id="mail_status" class="container rounded p-3 border bg-light border">
	    <h2>Email status</h2>
	    <ol>
	    </ol>
	</div>
 </div>
</template>

<script>
export default {
  name: 'UserMailView',
  data () {
    return {
      msg: 'UserMail API Manager'
    }
  }
}
</script>

