<template>
  <div id="container" class="container">
    <h2>UserMail Admin UI</h2>
    	<div id="send_mail" class="pb-3 container rounded border">
	    <span class="alert alert-success alert-dismissible fade show" role="alert" id="feedback" v-model="feedback">{{ feedback }}</span>
	    <span class="alert alert-warning alert-dismissible fade show" role="alert" id="error" v-model="error">{{ error }}</span>
	    <h2>Send email</h2>
	    <form class="form" method="post" ref="mailform" @submit.prevent="putNow">
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
		<thead class="thead-dark">
		    <tr>
		    <th v-for="item of headers">
		      {{ item.text }}
		    </th>
		    <th></th>
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
		    <td><button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="fireDelete(item.mid)">
			    <span aria-hidden="true">&times;</span>
			</button>
		    </td>
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
	feedback: '',
	uid: 1,
	mtid:1,
	mail_to:'',
	content:'',
	subject:'',
	error:'',
	timer: ''
      }
    },
    mounted: function () {
	this.getData()
	this.timer = setInterval(this.getData(), 1000)
    },
    methods: {
	getData() {
	    console.log('getData() called');
	    axios.get('http://' + location.hostname + ':8008/user/1/mail/').then((response) => {
		    
		    this.mails = response.data.results;
		}, function() {
		    this.error('Oops, something went wrong with the GET API call to get the mails');
		});
	},
	putNow() {
	    this.feedback = this.error = '';
	    axios.put('http://' + location.hostname + ':8008/user/1/mail/', 
	      {uid:this.uid,
	       mtid:this.mtid,
	       mail_to:this.mail_to,
	       content:this.content,
	       subject:this.subject
	       }
	      ).then((response) => {
		    if (response.data.result){
			this.getData();
			this.feedback = "New email queued for sending";
			this.resetForm()
		    }
		    else if (response.data.error){
			this.error = response.data.error;
		    }
		    
		}, function() {
		    console.log(response);
		    this.error('Oops, something went wrong with the PUT API call to create your emails');
		}).catch(function (error) {
                    console.log(error);
                });
	},
	resetForm() {
	    console.log('Reset form');
	    this.uid = 1;
	    this.mtid = 1;
	    this.mail_to = '';
	    this.content ='';
	    this.subject =  '';
	},
	fireDelete(mid) {
	    this.feedback = this.error = '';
	    axios.delete('http://' + location.hostname + ':8008/user/1/mail/'+mid)
	    .then((response) => {
		this.getData();
		this.feedback = "Email deleted from system";
		this.resetForm();
	    });
	}
	
    },
    beforeDestroy() {
	clearInterval(this.timer)
    }
}
</script>

<style>
    .alert:empty{
	display:none;
    }
</style>