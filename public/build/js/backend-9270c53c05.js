$(function(){

	$('body')
		.on('click', '.delete-list-item', function(e){
			e.preventDefault();
			var self = $(this);
			bootbox.confirm("Delete this entry?", function(result){
				if(result) {
					$.ajax({
						url: '/' + self.attr('data-route') + '/' + self.attr('data-id'),
						type: 'delete',
						data: {
							_method: 'delete'
						},
						success: function(){
							self.parents('tr').fadeOut(1000, function(){
								$(this).remove();
							})
						}
					});
				}
			});

		})
		.on('click', '.editable', function(e){
			e.preventDefault();
			new inlineEditableField($(this));
		})


});


function inlineEditableField(toggler){
	var self = this;

	this.toggler = toggler;
	this.model = toggler.parents('table').attr('data-route'), 
	this.field = toggler.attr('data-field'), 
	this.item_id = toggler.parents('tr').attr('data-id'),
	this.oldValue = toggler.text(),
	this.input = $('<input type="text" class="form-control" value="'+this.oldValue+'">')
	this.postData = {
		_method: 'PATCH'
	};
	self.escapeKey = false;

	self.showInput();
	self.onInputKeyup();
	self.onInputBlur();	
}

	inlineEditableField.prototype.onInputKeyup = function(){
		var self = this;

		this.input.on('keyup', function(e){

			// Enter Pressed
			if(e.keyCode == 13){

				if(self.sameValue()){
					
					self.hideInput();

				} else {

					var result = self.patch();
					if(result.success === true){
						self.hideInput();
					} else {
						self.input.val(self.oldValue);
						bootbox.alert(result.message);
					}
				}

			} 
			// Escape Key Pressed
			if (e.keyCode == 27) {
				if(self.sameValue()){
					self.hideInput();
				} else {
					self.escapeKey = true;
					self.saveOrCancel();
				}
			}		

		});
	}

	inlineEditableField.prototype.onInputBlur = function(){
		var self = this;

		this.input.on('blur', function(){
			if(self.sameValue()){
				self.hideInput();
			} else {
				if(self.escapeKey === true) {
					return;
				}
				self.saveOrCancel();
			}
		});
	}

	inlineEditableField.prototype.sameValue = function(){

		if(this.input.val().trim() == this.oldValue){
			this.input.val(this.input.val().trim());
			return true;
		}

		return false;
	}

	inlineEditableField.prototype.saveOrCancel = function(){
		var self = this;

		if(this.input.val().trim() == ''){

			this.input.val(this.oldValue);
			this.hideInput();

		} else if((this.input.val() != this.oldValue)){

			bootbox.confirm('Save updated input?', function(result) {

	  		if(result === false){
					self.input.val(self.oldValue);
					self.hideInput();
	  		}else{
	  			self.patch();
					self.hideInput();
	  		}
			}); 
		}
	}

	inlineEditableField.prototype.hideInput = function(){
		if(this.input.val() != this.oldValue) {
			this.toggler.text(this.input.val());
		}
		this.toggler.show();
		this.input.off('keyup').remove();
	}

	inlineEditableField.prototype.showInput = function(){
		this.toggler.hide().after(this.input);
		this.input.focus();
	}

	inlineEditableField.prototype.patch = function(){

		var self = this,
				result = {
					success: false,
					message: ''
				};

		this.postData[this.field] = this.input.val();

		$.ajax({
			async: false,
			url: '/'+this.model+'/'+ this.item_id,
			type: 'PATCH',
			data: this.postData, 
			beforeSend: function(){},
			error: function(response){
				if(response.status == 422){
					for(var field in response.responseJSON){
						result.message += response.responseJSON[field] + "\n";
					}
				} else if(response.status == 401) { 
					bootbox.alert('Not Authorized');
				}
			},
			success: function(response){
				result.success = true;
			}
		});		

		return result;
	}

$.ajaxSetup(
{
  headers:
  {
    'X-CSRF-Token': Laravel.csrfToken
  }
});

function log(data){
	console.log(data);
}
//# sourceMappingURL=backend.js.map
