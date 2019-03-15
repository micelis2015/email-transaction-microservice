<template>
  <div id="container" class="container">
    <h2>UserMail Admin UI</h2>
	<div id="send_mail" class="pb-3 container rounded border">
	    <h2>Send email</h2>
	    <form class="form" method="post" ref="mailform" @submit.prevent="postNow">
	    <div class="form-group">
		<div class="row">
		  <div class="col">
		    <label for="uid">User ID</label>
		    <input id="uid" v-model="uid" class="form-control" value="1" type="text" ></input>
		  </div>
		  <div class="col">
		    <label for="mtid">Email type</label>
		    <select id="mtid" v-model="mtid" class="form-control">
			<option value="1">HTML</option>
			<option value="2">MarkDown</option>
			<option value="3">Plain Text</option>
		      </select>
		    </div>
		</div>
	    </div>  
	    <div class="form-group">
		<label for="mail_to">Email address(es)</label>
		<input id="mail_to" v-model="mail_to" class="form-control" type="text" value="trythis@example.com, anothermail@example.com" ></input>
	    </div>
	    <div class="form-group">
		<label for="subject">Subject</label>
		<input id="subject" v-model="subject" class="form-control" type="text" value="This is a email" ></input>
	    </div>
	    <div class="form-group">
		<label for="content">Content</label>
		<textarea id="content" v-model="content" class="form-control" rows="3" ></textarea>
	     </div>
	     <button type="submit" class="btn btn-primary">Send</button>
	     </form>
	</div>
	<div id="mail_status" class="mt-5 container rounded p-3 border">
	    <h2>Email status</h2>
	    <table v-if="mails && mails.length" class="table table-striped">
		<thead class="thead-dark"><tr>
		    <th v-for="item of headers">
		      {{ item.text }}
		    </th>
		    </tr>
		</thead>
		<tbody>
		<tr v-for="item of mails">
		    <td>{{ item.mid }}</td>
		    <td>{{ item.uid }}</td>
		    <td><strong>{{ item.status }}</strong></td>
		    <td>{{ item.type }}</td>
		    <td>{{ item.name }}</td>
		    <td>{{ item.mail_to }}</td>
		    <td>{{ item.subject }}</td>
		    <td>{{ item.content }}</td>
		    <td>{{ item.created_at }}</td>
		    <td>{{ item.updated_at }}</td>
		</tr>
		</tbody>
	      </table>
	</div>
 </div>
</template>

<script>

import axios from 'axios';

export default {
  data() {
    return {
	headers: [
	    { text: 'mid', value: '' },
	    { text: 'uid', value: '1' },
	    { text: 'status', value: 'Send' },
	    { text: 'type', value: 'html' },
	    { text: 'provider', value: 'SendGrid' },
	    { text: 'mail_to', value: '' },
	    { text: 'subject', value: '' },
	    { text: 'content', value: '' },
	    { text: 'created', value: '' },
	    { text: 'updated', value: '' }
	    ],
	mails: [],
	feedback: [],
	uid: 1,
	mtid:1,
	mail_to:'',
	content:'',
	subject:''
      }
    },
    created: function () {
	axios.get('http://local.site:8008/user/1/mail/').then((response) => {
		    console.log(response.data);
		    this.mails = response.data.results;
		}, function() {
		    alert('oops, something went wrong with the GET API call to get the mails');
		});
    },
    methods: {
	postNow() {
	    
	    axios.put('http://local.site:8008/user/1/mail/', 
	      {uid:this.uid,
	       mtid:this.mtid,
	       mail_to:this.mailto,
	       content:this.content,
	       subject:this.subject
	       }
	      ).then((response) => {
		    console.log('bye');
		    console.log(response.data);
		    console.log(response.result);
		    this.feedback = response.data.results;
		}, function() {
		    console.log('there');
		    console.log(response);
		    alert('oops, something went wrong with the GET API call to get the mails');
		}).catch(function (error) {
                    console.log(error);
                });
	 }
    }
}
</script>
