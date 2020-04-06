<script type="text/javascript">
    $(document).ready(function () {
        
        $("body").on('click', '.userstatus', function () {
            
            var obj = $(this);
            var id = obj.attr('data-id');
            var status = obj.attr('data-status');
            var status_update = 1;
            if(status == 1){
            status_update = 0;    
            }
            $.ajax({
                type: "POST",
                url: "{{ URL::route('admin.userstatus') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id,
                    status: status
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if(data == true){
                         if(status_update == 1){
                            obj.removeClass('btn-success fa-check'); 
                            obj.addClass('btn-danger fa-remove');
                            obj.attr('data-status', status_update);
                         }else{
                            obj.removeClass('btn-danger fa-remove'); 
                            obj.addClass('btn-success fa-check');
                            obj.attr('data-status', status_update);
                         }  
                        }
                    }
                },
                complete: function (data) {
                    
                }});
            return false;
        });
        
        $("body").on('click', '.searchstatus', function () {
            
            var obj = $(this);
            var id = obj.attr('data-id');
            var status = obj.attr('data-status');
            var status_update = 1;
            if(status == 1){
            status_update = 0;    
            }
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.searchstatus') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id,
                    status: status
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if(data == true){
                         if(status_update == 1){
                            obj.removeClass('btn-success fa-check'); 
                            obj.addClass('btn-danger fa-remove');
                            obj.attr('data-status', status_update);
                         }else{
                            obj.removeClass('btn-danger fa-remove'); 
                            obj.addClass('btn-success fa-check');
                            obj.attr('data-status', status_update);
                         }  
                        }
                    }
                },
                complete: function (data) {
                    
                }});
            return false;
        });
        
        $("body").on('click', '.categorystatus', function () {
            
            var obj = $(this);
            var id = obj.attr('data-id');
            var status = obj.attr('data-status');
            var status_update = 1;
            if(status == 1){
            status_update = 0;    
            }
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.categorystatus') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id,
                    status: status
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if(data == true){
                         if(status_update == 1){
                            obj.removeClass('btn-success fa-check'); 
                            obj.addClass('btn-danger fa-remove');
                            obj.attr('data-status', status_update);
                         }else{
                            obj.removeClass('btn-danger fa-remove'); 
                            obj.addClass('btn-success fa-check');
                            obj.attr('data-status', status_update);
                         }  
                        }
                    }
                },
                complete: function (data) {
                    
                }});
            return false;
        });
        
        $("body").on('click', '.poststatus', function () {
            
            var obj = $(this);
            var id = obj.attr('data-id');
            var status = obj.attr('data-status');
            var status_update = 1;
            if(status == 1){
            status_update = 0;    
            }
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.poststatus') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id,
                    status: status
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if(data == true){
                         if(status_update == 1){
                            obj.removeClass('btn-success fa-check'); 
                            obj.addClass('btn-danger fa-remove');
                            obj.attr('data-status', status_update);
                         }else{
                            obj.removeClass('btn-danger fa-remove'); 
                            obj.addClass('btn-success fa-check');
                            obj.attr('data-status', status_update);
                         }  
                        }
                    }
                },
                complete: function (data) {
                    
                }});
            return false;
        });
        
        $("body").on('click', '.postread', function () {

            var obj = $(this);
            var id = obj.attr('data-id');
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.postread') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if (data == true) {
                                obj.removeClass('btn-danger fa-remove');
                                obj.addClass('btn-success fa-check');

                        }
                    }
                },
                complete: function (data) {

                }});
            return false;
        });
        
        $("body").on('click', '.commentstatus', function () {
            
            var obj = $(this);
            var id = obj.attr('data-id');
            var status = obj.attr('data-status');
            var status_update = 1;
            if(status == 1){
            status_update = 0;    
            }
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.commentstatus') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id,
                    status: status
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if(data == true){
                         if(status_update == 1){
                            obj.removeClass('btn-success fa-check'); 
                            obj.addClass('btn-danger fa-remove');
                            obj.attr('data-status', status_update);
                         }else{
                            obj.removeClass('btn-danger fa-remove'); 
                            obj.addClass('btn-success fa-check');
                            obj.attr('data-status', status_update);
                         }  
                        }
                    }
                },
                complete: function (data) {
                    
                }});
            return false;
        });
        
        $("body").on('click', '.commentread', function () {

            var obj = $(this);
            var id = obj.attr('data-id');
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.commentread') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if (data == true) {
                                obj.removeClass('btn-danger fa-remove');
                                obj.addClass('btn-success fa-check');

                        }
                    }
                },
                complete: function (data) {

                }});
            return false;
        });
        
        $("body").on('click', '.contactread', function () {

            var obj = $(this);
            var id = obj.attr('data-id');
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.contactread') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if (data == true) {
                                obj.removeClass('btn-danger fa-remove');
                                obj.addClass('btn-success fa-check');

                        }
                    }
                },
                complete: function (data) {

                }});
            return false;
        });
        
        $("body").on('click', '.contactreply', function () {

            var obj = $(this);
            var id = obj.attr('data-id');
            $.ajax({
                type: "post",
                url: "{{ URL::route('admin.contactreply') }}", // URL 
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: id
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data !== "") {
                        if (data == true) {
                                obj.removeClass('btn-danger fa-remove');
                                obj.addClass('btn-success fa-check');

                        }
                    }
                },
                complete: function (data) {

                }});
            return false;
        });
       
    });
</script>
