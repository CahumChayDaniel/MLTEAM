/**
 * Category Select input
 */
Craft.CategorySelectInput = Craft.BaseElementSelectInput.extend(
{
	selectable: false,
	sortable: false,

	init: function()
	{
		this.base.apply(this, arguments);
		this.addLastClasses();
	},

	getElements: function()
	{
		return this.$elementsContainer.find('li:not(.hidden) > .row .element');
	},

	initElements: function($elements)
	{
		this.initCheckboxes($elements.siblings('.checkbox'));
	},

	initCheckboxes: function($checkboxes)
	{
		this.removeListener($checkboxes, 'change');
		this.addListener($checkboxes, 'change', 'onCheckboxChange');
	},

	onCheckboxChange: function(ev)
	{
		var $checkbox = $(ev.currentTarget);

		if ($checkbox.prop('checked'))
		{
			// Make sure everything leading up to this is checked
			$checkbox.closest('li').parentsUntil(this.$elementsContainer, 'li').children('.row').find('.checkbox').prop('checked', true);
		}
		else
		{
			// Make sure everything under it is also unchecked
			$checkbox.closest('li').children('ul').find('.checkbox').prop('checked', false);
		}
	},

	createNewElement: function(elementInfo)
	{
		var $li = this.$container.find('#'+this.id+'-category-'+elementInfo.id),
			$parentLis = $li.parentsUntil(this.$elementsContainer, 'li'),
			$allLis = $li.add($parentLis),
			$parentElements = $parentLis.children('.row').find('.element'),
			$checkboxes = $allLis.children('.row').find('.checkbox'),
			$element = $li.children('.row').find('.element');

		// Make sure all parent elements are visible and checked
		$allLis.removeClass('hidden');
		$checkboxes.prop('checked', true);

		this.initCheckboxes($checkboxes);
		this.$elements = this.$elements.add($parentElements);

		return $element;
	},

	onSelectElements: function()
	{
		this.addLastClasses();
		this.base.apply(this, arguments);
	},

	addLastClasses: function()
	{
		// Add the "last" class to the last visible <li>s in each <ul>
		var $uls = this.$elementsContainer.find('ul');

		for (var i = 0; i < $uls.length; i++)
		{
			var $ul = $($uls[i]);

			$ul.children('.last').removeClass('last');
			$ul.children(':not(.hidden):last').addClass('last');
		}
	}
});
