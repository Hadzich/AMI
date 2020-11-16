# AMI
asterisk AMI with GUI

Install dependecies. 
Step 1
start websocket php /bin/ami-server.php
Step 2 
Start php listner.php 

This is just simple task to show represent AMI data on GUI. 
On index PHP we will see number of users, online users and ongoing calls. 
If there is ongoing call it will be showen on page as CARD where we can interact. 
We can hangup the call or pres record for recording the calls. 
We are using websockets so data is live. 

On page users we have all users in asterisk and it will show recorded files which we can play. 
And extensions is just represeting the extensions.confg file. This can be easly changed to type in name od confg file and file will be showen. 


Configuration in asterisk

1) In http.conf:

	[general]
	enabled = yes
	enablestatic = yes
	
2) In manager.conf

	[general]
	enabled = yes
	webenabled = yes
	
3) Create an appropriate entry in manager.conf for the administrative user

    [test]
    secret = test123
    read = system,call,log,verbose,command,agent,config,read,write,originate
    write = system,call,log,verbose,command,agent,config,read,write,originate
