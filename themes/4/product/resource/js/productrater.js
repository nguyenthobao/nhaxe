var __slice = [].slice;

(function($, window) {
    var Starrr;

    Starrr = (function() {
        Starrr.prototype.defaults = {
            rating: void 0,
            numStars: 5,
            change: function(e, value) {}
        };

        function Starrr($el, options) {

                var i, _, _ref,
                _this = this;

            this.options = $.extend({}, this.defaults, options);
            this.$el = $el;
            _ref = this.defaults;
            for (i in _ref) {
                _ = _ref[i];
                if (this.$el.data(i) != null) {
                    this.options[i] = this.$el.data(i);
                }
            }
         
            this.createStars();

            this.syncRating();
                if($('#stars').attr('data-is-rater')!=1){
                    this.$el.on('mouseover.starrr', 'i', function(e) {
                        return _this.syncRating(_this.$el.find('i').index(e.currentTarget) + 1);
                    });
                    this.$el.on('mouseout.starrr', function() {
                        return _this.syncRating();
                    });
                    if($('#stars').attr('data-is-login')!=0){
                        this.$el.on('click.starrr', 'i', function(e) {
                            return _this.setRating(_this.$el.find('i').index(e.currentTarget) + 1);
                        });
                    }
                    
                    this.$el.on('starrr:change', this.options.change);
                }

        }

        Starrr.prototype.createStars = function() {
            var _i, _ref, _results;

            _results = [];
            for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
                _results.push(this.$el.append("<i class='fa fa-star-o'></i>"));
            }
            return _results;
        };

        Starrr.prototype.setRating = function(rating) {
            /*if (this.options.rating === rating) {
                rating = void 0;
            }*/
            this.options.rating = rating;
                this.syncRating();
            return this.$el.trigger('starrr:change', rating);
            
            
        };

        Starrr.prototype.syncRating = function(rating) {
            var i, _i, _j, _ref;

            rating || (rating = this.options.rating);
            if (rating) {
                for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
                    this.$el.find('i').eq(i).removeClass('fa-star-o').addClass('fa-star');
                }
            }
            if (rating && rating < 5) {
                for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
                    this.$el.find('i').eq(i).removeClass('fa-star').addClass('fa-star-o');
                }
            }
            if (!rating) {
                return this.$el.find('i').removeClass('fa-star').addClass('fa-star-o');
            }
        };

        return Starrr;

    })();
    return $.fn.extend({
        starrr: function() {
            var args, option;

            option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
            return this.each(function() {
                var data;

                data = $(this).data('star-rating');
                if (!data) {
                    $(this).data('star-rating', (data = new Starrr($(this), option)));
                }
                if (typeof option === 'string') {
                    return data[option].apply(data, args);
                }
            });
        }
    });
})(window.jQuery, window);

$(function() {
    return $(".starrr").starrr(); 
});

function relogin(){
    var ext = $('body').data('extension');
    var urlHome = $('body').data('home_url');
    toastr.error('<a href="' + urlHome + '/user-login' + ext + '">' + $('#stars').attr('data-text-login') + '</a>');
    return false;
}

$( document ).ready(function() {

  $('#stars').on('starrr:change', function(e, value){
     e.preventDefault();
    var star = value;
    var ext = $('body').data('extension');
    var urlHome = $('body').data('home_url');
    var urlSend = urlHome + '/product-ajaxRater-addRate' + ext;
    var id_product = $(this).attr('data-id-product');
    var text = $(this).attr('data-name');

    var dataString = {
        'id_product': id_product,
        'star': star
    };

    $.getJSON(urlSend, dataString)
        .done(function(msg) {
            if (msg.res == false) {
                if (msg.error_code == 1) {
                    toastr.error('<a href="' + urlHome + '/user-login' + ext + '">' + msg.msg + '</a>');
                } else {
                    
                    return false;
                }
            } else {
                
                $('#rate').html(msg.total_rate);    
                $('#stars').attr('data-is-rater',1);
                $('#display-first-rating').remove();
                toastr.success(msg.msg + text);
            }
        })
        .fail(function(jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            console.log("Request Failed: " + err);
        });

    return false;
    
  });
  
});


// $(function(){
//   $("ul.rating").on('mouseover', function () {
//      if($(this).attr('data-is-rater')==1){
//        $("ul.rating").find('li a').css('background', 'transparent'); 
//      }
     
//   }).on('mouseout', function () {
//     if($(this).attr('data-is-rater')==1){
//        $("ul.rating").find('li a').css('background', 'transparent');
//      }
     
//   });
// })


// $('body').on('click', '.rater-click', function(e) {
//     e.preventDefault();
//     var star = $(this).attr('data-rating');
//     var ext = $('body').data('extension');
//     var urlHome = $('body').data('home_url');
//     var urlSend = urlHome + '/product-ajaxRater-addRate' + ext;
//     var id_product = $(this).attr('data-id-product');
//     var text = $(this).attr('data-name');

//     var dataString = {
//         'id_product': id_product,
//         'star': star
//     };

//     $.getJSON(urlSend, dataString)
//         .done(function(msg) {
//             if (msg.res == false) {
//                 if (msg.error_code == 1) {
//                     toastr.error('<a href="' + urlHome + '/user-login' + ext + '">' + msg.msg + '</a>');
//                 } else {
//                     //toastr.warning(msg.msg + text);
//                     return false;
//                 }
//             } else {
//                 $('#rate').html(msg.star_tb);

//                 if (msg.star_tb == 1) {
//                     $('ul.rating').removeClass().attr('class', 'rating onestar').attr('data-is-rater',1);
//                 } else if (msg.star_tb == 2) {
//                     $('ul.rating').removeClass().attr('class', 'rating twostar').attr('data-is-rater',1);;
//                 } else if (msg.star_tb == 3) {
//                     $('ul.rating').removeClass().attr('class', 'rating threestar').attr('data-is-rater',1);;
//                 } else if (msg.star_tb == 4) {
//                     $('ul.rating').removeClass().attr('class', 'rating fourstar').attr('data-is-rater',1);;
//                 } else if (msg.star_tb == 5) {
//                     $('ul.rating').removeClass().attr('class', 'rating fivestar').attr('data-is-rater',1);;
//                 }
//                  $('#display-first-rating').remove();
//                  $('#display-total-rating').show();
//                 $('#rate').html(msg.total_rate);
//                 $('input.rate-radio').prop('disabled', true);
//                 toastr.success(msg.msg + text);
//             }
//         })
//         .fail(function(jqxhr, textStatus, error) {
//             var err = textStatus + ", " + error;
//             console.log("Request Failed: " + err);
//         });

//     return false;
// })