(function($)
{
	$.Redactor.prototype.accordion = function() {
		return {
			init: function() {
				var button = this.button.addAfter('video', 'accordion', 'Элемент аккордеона');
				this.button.addCallback(button, this.accordion.show);
			},
			getTemplate: function()
			{
				return String()
				+ '<div class="modal-section" id="redactor-modal-accordion-insert">'
					+ '<section>'
						+ '<label>' + 'Введите заголовок' + '</label>'
						+ '<input id="redactor-insert-accordion-title" type="text" />'
					+ '</section>'
					+ '<section>'
						+ '<label>' + 'Текст содержимого' + '</label>'
						+ '<textarea id="redactor-insert-accordion-text" style="height: 5em;" />'
					+ '</section>'
				+ '</div>';
			},
			show: function() {
				this.modal.addTemplate('accordion', this.accordion.getTemplate());
				this.modal.load('accordion', 'Accordion', 700);
				
				this.selection.save();
				//var sel = this.selection.get();
				//$('#redactor-insert-accordion-text').val(sel);
				
				this.modal.createActionButton().text('Вставить').on('click', this.accordion.insert);
				this.modal.show();
			},
			insert: function()
			{
				var title = $('#redactor-insert-accordion-title').val();
				var text = $('#redactor-insert-accordion-text').val();
				var data = '';
				data += '<div>';
				data +=		'<a href="#" class="accordion-toggle">'+title+'</a>';
				data +=		'<div class="accordion-text">' + text + '</div>';
				data += '</div>';
				
				this.selection.restore();
				this.insert.htmlWithoutClean(data);
				
				this.modal.close();
				this.observe.load();
				//this.code.sync();
			}
		};
	};
})(jQuery);