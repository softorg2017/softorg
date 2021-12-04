

function wechat_share(website_name,page_id,sort,module,share)
{
    $.get(
        "/org/share",
        {
            '_token': $('meta[name="_token"]').attr('content'),
            'website_name': website_name,
            'page_id': page_id,
            'sort': sort,
            'module': module,
            'share': share
        },
        function(data)
        {

            if(!data.success) layer.msg(data.msg);
        },
        'json'
    );
}

