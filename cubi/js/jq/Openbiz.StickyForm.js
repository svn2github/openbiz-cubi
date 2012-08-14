/**
 * Openbiz Sticky Form class
 */
Openbiz.StickyForm = Class.create(Openbiz.Form,
{
	collectData: function($super)
    {
    	formData = $super() + "&_selectedId=" + this.selectedId
    						+ "&text=" +  this.noteText
    						+ "&pos_x=" + this.notePos_x
    						+ "&pos_y=" + this.notePos_y
    						+ "&width=" + this.noteWidth
    						+ "&height=" + this.noteHeight
    						;
        return formData;
    }
});