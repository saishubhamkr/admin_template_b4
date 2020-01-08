$(document).ready(function(e) {
	setTimeout(function() {
		$('.msg-popup').fadeOut();
	},5000);
    $('body').on('click','.has-treeview',function(e){
		var current=$(this);
		$('.has-treeview').each(function(index, element) {
            if($(this).not(current).hasClass('menu-open')){
				$(this).removeClass('menu-open').find('.nav-treeview').slideUp();
			}
        });
	});
	if($('.default-notify').length){
		$this=$('.default-notify');
		$(document).Toasts('create', {
			title: $this.data('title'),
			icon: $this.data('icon'),
			class: 'bg-'+$this.data('status'),
			position: $this.data('position'),
			autohide: true,
			delay: 5000,
			body: $this.html()
		});
	}
	if($('.sweetalert-notify').length){
		$this=$('.sweetalert-notify');
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 5000
		});
		
		Toast.fire({
			type: $this.data('status'),
			position: $this.data('position'),
			title: $this.html()
		});
	}
	if($('.toastr-notify').length){
		$this=$('.toastr-notify');
		toastr.options={
		  "closeButton": true,
		  "positionClass": $this.data('position'),
		  "timeOut": "5000"
		};
		toastr[$this.data('status')]($this.html(), $this.data('title'));
	}
});