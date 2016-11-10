if(Dropzone != undefined){
	Dropzone.autoDiscover = false;
}


$(function(){
	
	var app = new App($('#app'));

	$('#modal-log-in').find('form').on('submit', function(e){
		e.preventDefault();
		var form = $(this);
		$.ajax({
			type: 'post',
			url: '/customer/login',
			data: form.serialize(),
			beforeSend: function(){},
			error: function(response){
				app.displayFormErrors(form, response.responseJSON);
			},
			success: function(response){
				if (response.result == 'success') {
					$('#modal-log-in').modal('hide');
					app.updateProfileLinks();
					app.initAddressForm();
				} else {

				}
			}
		})
	})


});

App.prototype.updateProfileLinks = function(){
	$.ajax({
		url: '/my/credentials',
		success:function(response){
			$('header, footer').find('.profile-link').replaceWith(response);
			// $('#customer-credentials').html($(response.headerCredentials));
			// $('footer').find('a[data-toggle="modal"]').replaceWith(response.footerCredentials)
		}
	})
}


function App(container){
	var self = this;

	this.appContainer = container;
	this.dropZone = null;
	this.filename = null;
	this.formComment = null;
	self.formAddress = null;
	self.formSubproductProperties = null;

	this.productRowCounter = 0;
	this.productColCounter = 1;
	this.productItemsInRow = 4;
	this.productWidthBase = 120;
	this.productHeightBase = 140;
	this.productTopOffset = 65;

	this.subproductsInitiated = false;
	this.subproductRowCounter = 0;
	this.subProductColCounter = 1;
	this.subproductItemsInRow = 3;
	this.subproductWidthBase = 140;
	this.subproductHeightBase = 140;
	this.subproductTopOffset = 180;

	this.subproductPropertiesInitiated = false;

	this.blockLayer = $('#blocked');

	this.initProducts();
	this.initDropzone();

	this.initAddressForm();
}


App.prototype.initProducts = function(){

	var self = this;

	self.blockUserInteractions(1000);

	$('.product').each(function(i){

		$(this).css({
			left: self.productWidthBase * self.productColCounter,
			top: self.productTopOffset + self.productHeightBase * self.productRowCounter
		});

		self.productColCounter++;
		if (self.productColCounter > self.productItemsInRow) {
			self.productColCounter	= 1;	
			self.productRowCounter++;
		}

	})

	$('.product').on('click.selectProduct', selectProduct);

	function selectProduct(e){
		e.preventDefault();
		self.blockUserInteractions(1700);

		var product = $(this);

		$.post('/order/collect', { 
			product: product.attr('data-id')
		})	
			.fail(function(response){
				self.displayAjaxResponseError(response);
			})
			.done(function(response){

				$('.product').not(product).removeClass('visible');
				self.getSubProducts(product.attr('data-id'));

				product.addClass('selected')
					.off('click.selectProduct')
					.on('click.unselectProduct', unselectProduct);
				
				self.screenUp();
				
				setTimeout(function(){
					self.screenUp();
				}, 600);

			});
	}

	function unselectProduct(e){
		e.preventDefault();
		self.blockUserInteractions(1000);

		$('.product').addClass('visible');
		$(this).removeClass('selected')
			.on('click.selectProduct', selectProduct);

		if(self.dropZone != null && self.filename != null) {
			self.dropZone.removeAllFiles(true);
		}

		$('.subproduct').removeClass('selected').removeClass('visible');
		self.screenTo(1);
	}
}


App.prototype.initSubproducts = function(){

	var self = this;

	if(this.subproductsInitiated) return;
	this.subproductsInitiated = true; 

	
		$('.subproduct').each(function(i){

			$(this).css({
				left: self.subproductWidthBase * self.subProductColCounter,
				top: self.subproductTopOffset + self.subproductHeightBase * self.subproductRowCounter
			});

			self.subProductColCounter++;
			if (self.subProductColCounter > self.subproductItemsInRow) {
				self.subProductColCounter	= 1;	
				self.subproductRowCounter++;
			}

		});

	$('.subproduct').on('click.selectSubProduct', selectSubProduct);

	function selectSubProduct(e){
		e.preventDefault();

		self.blockUserInteractions(1500);

		var subProduct = $(this);
		subProduct.off('click.selectSubProduct');

		$.ajax({
			type: 'post',
			url: '/order/collect',
			data: {
				'variation_id' : subProduct.attr('data-id')
			},
			error: function(response){
				subProduct.on('click.selectSubProduct');
				self.displayAjaxResponseError(response);
			},
			success: function(response){

				$('.subproduct').not(subProduct).removeClass('visible');
				
				subProduct.addClass('selected')
					.on('click.unselectSubProduct', unSelectSubProduct);

				self.screenUp();
				self.initSubproductProperties();

				setTimeout(function(){
					self.screenUp();
				}, 600);
			}
		})


	}

	function unSelectSubProduct(e){
		e.preventDefault();

		self.blockUserInteractions(1000);

		$(this).off('.click.unselectSubProduct')
			.removeClass('selected')
			.on('click.selectSubProduct', selectSubProduct);

		$('.subproduct').addClass('visible');

		self.screenTo(6);
	}
}


App.prototype.initSubproductProperties = function(){
	var self = this;

	if(this.subproductPropertiesInitiated === true) return;
	
	self.formSubproductProperties = $('.subproduct-properties');
	self.subproductPropertiesInitiated = true;

	self.formSubproductProperties.on('submit', function(e){
		e.preventDefault();

		$.ajax({
			type: 'post',
			url: '/order/collect',
			data: $(this).serialize(),
			beforeSend: function(){
				self.blockUserInteractions();
			},
			error: function(response){
				self.displayFormErrors(self.formSubproductProperties, response.responseJSON);
				self.unblockUserInteractions();
				// self.displayAjaxResponseError(response);
			},
			success: function(response){
				self.blockUserInteractions(1100);
				self.screenUp();
			}
		})

	})
}


App.prototype.getSubProducts = function(productId){
	var self = this;

	$.ajax({
		url: '/product/'+productId+'/variations',
		error: function(response){
		},
		success: function(response){
			$('.subproducts').html(response);

			self.subproductsInitiated = null;
			self.subproductRowCounter = 0;
			self.subProductColCounter = 1;

		}
	})
}



App.prototype.initCommentForm = function(){
	var self = this;

	if(!self.formComment) {

		self.formComment = $('.form-comment');

		self.formComment.on('submit', function(e){
			e.preventDefault();

			self.blockUserInteractions(1100);
			self.screenUp();

			$('.subproduct').addClass('visible');

			$.post('/order/collect', {
				comment: $(this).find('textarea').val()
			});

			self.initSubproducts();
		})

	}
}


App.prototype.initAddressForm = function(){

	var self = this;

	$.ajax({
		url: '/order/credentials',
		success: function(response){

			self.formAddress = $(response);
			$('.delivered-to-container').html(self.formAddress);

			self.formAddress.on('submit', function(e){
				e.preventDefault();
				self.blockUserInteractions();

				var button = $('button[type="submit"]', self.formAddress);
				


				$.ajax({
					type: 'post',
					url: '/order/collect' ,
					data: {
						address1: self.formAddress.find('input[name="address1"]').val()
					},
					beforeSend: function(){
						button.attr({disabled: 'disabled'});
					},
					error: function(response){
						self.unblockUserInteractions();
						self.displayFormErrors(self.formAddress, response.responseJSON);
						// self.displayAjaxResponseError(response);
						button.removeAttr('disabled');
					},
					success: function(response){
						self.blockUserInteractions(1500);
						button.removeAttr('disabled');

						self.saveOrder();
					}
				});

			})


		}
	})

}


App.prototype.saveOrder = function(){
	var self = this;

	$.ajax({
		type: 'post',
		url: '/order',
		data: this.formAddress.serialize(),
		beforeSend: function(){
			self.blockUserInteractions();
			self.formAddress.find('button').attr({disabled: 'disabled'});
		},
		error: function(response){
			self.displayFormErrors(self.formAddress, response.responseJSON);
			// self.displayAjaxResponseError(response);
			self.formAddress.find('button').removeAttr('disabled');
			self.unblockUserInteractions();
		},
		success: function(response){
			self.formAddress.find('button').removeAttr('disabled');
			self.unblockUserInteractions();
			window.location = '/my/orders/checkout/'+response.orderId;
		}
	})
}

App.prototype.initDropzone = function(){
	var self = this;

	var x = $('#design-upload').dropzone({
		url: '/file/temporary/customer-design',
		maxFilesize: 5, // MB
		headers: {
	    'X-CSRF-Token': $('meta[name="csrf_token"]').attr('content')
	  },
	  init: function(){
	  },
	  error: function(file, response) {
	  },
	  success: function(file, response) {
	  	self.dropzoneSuccess(response.filenameOriginal);
	  }
	});

	$('.file').on('click', function(e){
		e.preventDefault();
		
		self.blockUserInteractions(1100);
		self.screenTo(3);

		$('.subproduct').removeClass('selected').removeClass('visible');
		if(self.dropZone && self.filename){
			self.dropZone.removeAllFiles();
		}
	})

	this.dropZone = x[0].dropzone;
}


App.prototype.dropzoneSuccess = function(filename){

	var self = this;

	self.blockUserInteractions(1500);

	this.filename = filename;
	$('.filename').text(filename);
	this.screenUp();
	
	$('button[type="reset"]').on('click', function(e){
		self.blockUserInteractions(1400);
		self.screenTo(3);
		self.dropZone.removeAllFiles();
	})

	setTimeout(function(){
		self.screenUp();
		self.initCommentForm();
	}, 600);
}


App.prototype.displayAjaxResponseError = function(response){
	$.each(response.responseJSON, function(index, value){
		$.each(value, function(index, value){
			toastr.error(value);
		});
	});
}


App.prototype.screenUp = function(){
	var screen = this.getCurrentScreen();
	this.appContainer.removeClassWild('screen*').addClass('screen'+(screen.screenNumber+1));
}


App.prototype.screenDown = function(){
	var screen = this.getCurrentScreen();
	this.appContainer.removeClassWild('screen*').addClass('screen'+(screen.screenNumber-1));
	this.screenAdditionalActions(screen.screenNumber);
}


App.prototype.screenTo = function(value){
	var screen = this.getCurrentScreen();
	this.appContainer.removeClassWild('screen*').addClass('screen'+value);
	this.screenAdditionalActions(value);
}


App.prototype.getCurrentScreen = function(){
	var matches = this.appContainer.attr('class').match(/screen(\d)/i);
	return {
		currentClass: matches[0],
		screenNumber: parseInt(matches[1])
	}
}


App.prototype.screenAdditionalActions = function(screen){
	if(screen < 5){
		this.clearForm(this.formComment);
	}
	if (screen < 8){
		this.clearForm(this.formSubproductProperties);
	}
	if (screen < 9){
		this.clearForm(this.formAddress);
	}
}


App.prototype.blockUserInteractions = function(duration){
	var self = this;

	duration = duration || false;

	this.blockLayer.show();

	if(duration){
		setTimeout(function(){

			self.blockLayer.hide();

		}, duration);
	}

}

App.prototype.unblockUserInteractions = function(){
	this.blockLayer.hide();
}


App.prototype.displayFormErrors = function(form, errors){
	var self = this;

	this.clearFormErrors(form);

	for(var fieldError in errors){
		var field = form.find('*[name="'+fieldError+'"]');

		field
			.parents('.form-group')
				.addClass('has-error')
				.find('.help-block>strong').text(errors[fieldError]);
	}
}

App.prototype.clearForm = function(form){
	if(!form || !form.length) return;
	form[0].reset();
	this.clearFormErrors();
}

App.prototype.clearFormErrors = function(form){
	$('.form-group', form).removeClass('has-error').find('.help-block>strong').text('');	
}



$.fn.removeClassWild = function(mask) {
	return this.removeClass(function(index, cls) {
		var re = mask.replace(/\*/g, '\\S+');
		return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
	});
};




$.ajaxSetup(
{
  headers:
  {
    'X-CSRF-Token': Laravel.csrfToken
  }
});


function log(data){
	return console.log(data);
}
//# sourceMappingURL=app.js.map

//# sourceMappingURL=app.js.map
