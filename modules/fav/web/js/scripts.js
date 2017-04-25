if (typeof fav == "undefined" || !fav) {
    var fav = {};
}

fav = {
    init: function () {

        $favElementsCount = '[data-role=fav-element-count]';
        $addElementButton = '[data-role=fav-add-button]';
        $deleteElementButton = '[data-role=fav-delete-button]';
        $truncateFavButton = '[data-role=truncate-fav-button]';

        fav.csrf = jQuery('meta[name=csrf-token]').attr("content");
        fav.csrf_param = jQuery('meta[name=csrf-param]').attr("content");

        $(document).on('change', $favElementsCount, function () {

            var self = this,
                url = $(self).data('href');

            if ($(self).val() < 0) {
                $(self).val('0');
                return false;
            }

            favElementId = $(self).data('id');
            favElementCount = $(self).val();

            fav.changeElementCount(favElementId, favElementCount, url);
        });

        $(document).on('click', $addElementButton, function () {

            var self = this,
                url = $(self).data('url'),
                itemModelName = $(self).data('model'),
                itemId = $(self).data('id'),
                itemCount = $(self).data('count'),
                itemPrice = $(self).data('price');

            fav.addElement(itemModelName, itemId, itemCount, itemPrice, url);

            return false;
        });

        $(document).on('click', $truncateFavButton, function () {

            var self = this,
                url = $(self).data('url');

            fav.truncate(url);
			
			if (blockSelector = $(self).data('line-selector')) {
				console.log(blockSelector);
				$(blockSelector).hide('slow');
			}
            return false;
        });

        $(document).on('click', $deleteElementButton, function (e) {

            e.preventDefault();

            var self = this,
                url = $(self).data('url'),
                elementId = $(self).data('id');

            fav.deleteElement(elementId, url);

            if (lineSelector = $(self).data('line-selector')) {
                $(self).parents(lineSelector).last().hide('slow');
            }

            return false;
        });
        
        $(document).on('click', '.arr', this.changeInputValue);
        $(document).on('change', '.fav-element-before-count', this.changeBeforeElementCount);

        return true;
    },
    elementsListWidgetParams: [],
    jsonResult: null,
    csrf: null,
    csrf_param: null,
    deleteElement: function (elementId, url) {

        fav.sendData({elementId: elementId}, url);

        return false;
    },
    changeInputValue: function () {
        var val = parseInt(jQuery(this).siblings('input').val());
        var input = jQuery(this).siblings('input');

        if (jQuery(this).hasClass('downArr')) {
            if (val <= 0) {
                return false;
            }
            jQuery(input).val(val - 1);
        }
        else {
            jQuery(input).val(val + 1);
        }

        jQuery(input).change();

        return false;
    },
    changeBeforeElementCount: function () {
        if ($(this).val() <= 0) {
            $(this).val('0');
        }

        var id = $(this).data('id');
        var addButton = $('.fav-add-button' + id);
        $(addButton).data('count', $(this).val());
        $(addButton).attr('data-count', $(this).val());

        return true;
    },
    changeElementCount: function (favElementId, favElementCount, url) {

        var data = {};
        data.CartElement = {};
        data.CartElement.id = favElementId;
        data.CartElement.count = favElementCount;

        fav.sendData(data, url);

        return false;
    },
    addElement: function (itemModelName, itemId, itemCount, itemPrice, url) {

        var data = {};
        data.FavElement = {};
        data.FavElement.model = itemModelName;
        data.FavElement.item_id = itemId;
        data.FavElement.count = itemCount;
        data.FavElement.price = itemPrice;

        fav.sendData(data, url);

        return false;
    },
    truncate: function (url) {
        fav.sendData({}, url);
        return false;
    },
    sendData: function (data, link) {
        if (!link) {
            link = '/fav/element/create';
        }

        jQuery(document).trigger("sendDataToFav", data);

        data.elementsListWidgetParams = fav.elementsListWidgetParams;
        data[fav.csrf_param] = fav.csrf;

        jQuery('.fav-block').css({'opacity': '0.3'});
        jQuery('.fav-count').css({'opacity': '0.3'});
        jQuery('.fav-price').css({'opacity': '0.3'});

        jQuery.post(link, data,
            function (json) {
                jQuery('.fav-block').css({'opacity': '1'});
                jQuery('.fav-count').css({'opacity': '1'});
                jQuery('.fav-price').css({'opacity': '1'});

                if (json.result == 'fail') {
                    console.log(json.error);
                }
                else {
                    fav.renderFart(json);
                }

            }, "json");

        return false;
    },
    renderFart: function (json) {
        if (!json) {
            var json = {};
            jQuery.post('/fav/default/info', {},
                function (answer) {
                    json = answer;
                }, "json");
        }

        jQuery('.fav-block').replaceWith(json.elementsHTML);
        jQuery('.fav-count').html(json.count);
        jQuery('.fav-price').html(json.price);

        jQuery(document).trigger("renderFart", json);

        return true;
    },
};

fav.init();
