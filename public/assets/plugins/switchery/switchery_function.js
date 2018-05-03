
var green = '#00acac',
    red = '#ff5b57',
    blue = '#348fe2',
    purple = '#727cb6',
    orange = '#f59c1a',
    black = '#2d353c';

function renderSwitcher() {
    if ($('[data-render=switchery]').length !== 0) {
        $('[data-render=switchery]').each(function() {
            var themeColor = green;
            if ($(this).attr('data-theme')) {
                switch ($(this).attr('data-theme')) {
                    case 'red':
                        themeColor = red;
                        break;
                    case 'blue':
                        themeColor = blue;
                        break;
                    case 'purple':
                        themeColor = purple;
                        break;
                    case 'orange':
                        themeColor = orange;
                        break;
                    case 'black':
                        themeColor = black;
                        break;
                }
            }
            var option = {};
            option.color = themeColor;
            option.secondaryColor = ($(this).attr('data-secondary-color')) ? $(this).attr('data-secondary-color') : '#dfdfdf';
            option.className = ($(this).attr('data-classname')) ? $(this).attr('data-classname') : 'switchery';
            option.disabled = ($(this).attr('data-disabled')) ? true : false;
            option.disabledOpacity = ($(this).attr('data-disabled-opacity')) ? $(this).attr('data-disabled-opacity') : 0.5;
            option.speed = ($(this).attr('data-speed')) ? $(this).attr('data-speed') : '0.5s';
            var switchery = new Switchery(this, option);
        });
    }
};

function checkSwitcherState() {
    $('[data-click="check-switchery-state"]').live('click', function() {
        alert($('[data-id="switchery-state"]').prop('checked'));
    });
    $('[data-change="check-switchery-state-text"]').live('change', function() {
        $('[data-id="switchery-state-text"]').text($(this).prop('checked'));
    });
};
