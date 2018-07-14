(function(){

		/*
		 * SoapTest object.
		 */
		var SoapTest = {
			initialize: function(){
					var self = this;
					self.sendButton.addEventListener('click', function(){
						  self.send();
					});
					self.clearButton.addEventListener('click', function(){
							self.clear();
					});
			},
			requestContent: document.getElementById('request-content'),
			responseContent: document.getElementById('response-content'),
      controls: {
          url: document.getElementById('controls-url')
      },
			sendButton: document.getElementById('soap-send'),
			clearButton: document.getElementById('soap-clear'),
			envelopesContent: document.getElementsByClassName('envelope-content'),
			lockContainer: document.getElementById('lock'),
			clear: function(){
				for(var i in this.envelopesContent){
					this.envelopesContent[i].value = '';
				}
			},
			lock: function(){
				this.lockContainer.style.display = 'inherit';
				var self = this;
				self.requestContent.disabled = true;
				self.responseContent.disabled = true;
				self.sendButton.disabled = true;
				self.clearButton.disabled = true;
				self.controls.url.disabled = true;
			},
			unlock: function(){
				var self = this;
				this.lockContainer.style.display = 'none';
				self.requestContent.disabled = false;
				self.responseContent.disabled = false;
				self.sendButton.disabled = false;
				self.clearButton.disabled = false;
				self.controls.url.disabled = false;
			},
			send: function(){

				var self = this;
        var valid = true;

				var data = {
					request: self.requestContent.value,
          url: self.controls.url.value
				};

        if ( ! data.url ) {
        	alert('Empty URL');
        	valid = false;
        }

				if ( ! data.request ) {
					alert('Empty request');
					valid = false;
				}

        if ( !valid ) { return; }

				self.lock();

				var XHR = new XMLHttpRequest();
				var params = 'url=' + data.url + '&request=' + data.request;
				XHR.open('POST', '?send', true);
				XHR.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				XHR.onreadystatechange = function() {//Call a function when the state changes.
				    if ( XHR.readyState == 4 && XHR.status == 200 ) {
							var response = JSON.parse(XHR.responseText);
							if ( response.response ) { self.responseContent.value = response.response; }
						}
						self.unlock();
				}
				XHR.send(params);

				return;

				$.post('?send', data)
					.done(function(response){
						var response = jQuery.parseJSON(response);
						if(response){
							//self.requestContent.val(response.request);
							self.responseContent.val(response.response);
	                        $('#response-text-content').html(response.response);
						}
						self.unlock();
					})
					.fail(function(){
						self.unlock();
					});
			}
		};

		SoapTest.initialize();

})();
