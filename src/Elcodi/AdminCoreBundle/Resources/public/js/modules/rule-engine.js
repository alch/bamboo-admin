TinyCore.AMD.define('rule-engine', ['devicePackage' ], function () {
    return {
        onStart: function () {

            $('.comparation').on('change', '.comparated select', function () {

                var $this = $(this);
                $this.nextAll().remove();
                var $option = $this.find('option:selected');
                var value = $option.val();

                if (value == '') {

                    return;
                }

                var isAssociation = $option.data('association');
                var type = $option.data('type');

                if (isAssociation) {

                    var comparationIndex = parseInt($this.closest('.comparation').data('index'));
                    var index = parseInt($this.data('index')) + 1;

                    showComparisionFields(
                        $this.closest('.comparation'),
                        ''
                    );

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/rule/engine/api/" + encodeURI(type),
                        success: function (data) {

                            var selector = '<select name="comparation[' + comparationIndex + '][comparated][' + index + ']"';
                            selector += '<option value=""></option>';

                            $.each(data.fields, function (field, fieldData) {

                                selector += '<option data-association="false"';
                                selector += ' data-type="' + fieldData.type + '"';
                                selector += ' value="' + fieldData.fieldName + '">';
                                selector += field;
                                selector += '</option>';
                            });

                            $.each(data.associations, function (association, associationData) {

                                var associationName = associationData.collection
                                        ? associationData.name + '.length'
                                        : associationData.name;

                                var associationType = associationData.collection
                                        ? 'integer'
                                        : associationData.namespace;

                                selector += '<option data-association="' + !associationData.collection + '"';
                                selector += ' data-type="' + associationType+ '"';
                                selector += ' value="' + associationName + '">';
                                selector += associationName;
                                selector += '</option>';
                            });

                            selector += '</select>';

                            $this.after(selector);
                        }
                    });

                } else {

                    showComparisionFields(
                        $this.closest('.comparation'),
                        type
                    );
                }
            });

        /**
         * Given a comparation block, hide and show specific fields given the
         * field type
         *
         * @param comparationBlock
         * @param fieldType
         */
        function showComparisionFields(comparationBlock, fieldType) {

            var $switchables = comparationBlock.find('.sw-r');

            $switchables.attr('disabled', true);
            $switchables.addClass('hidden');

            $switchables
                .filter(function () {
                    var $this = $(this);

                    if (fieldType == '') {

                        return false;
                    }

                    return ($this.hasClass('sw-r-' + fieldType) ||
                        $this.hasClass('sw-r-all')) &&
                        !$this.hasClass('sw-r-n-' + fieldType);
                })
                .removeAttr('disabled')
                .removeClass('hidden');

            comparationBlock.find('.comparator select').val('');
        }

        }
    };
});

