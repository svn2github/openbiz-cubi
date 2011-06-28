/**
 * Openbiz Calendar Form class
 */
Openbiz.CalendarForm = Class.create(Openbiz.Form,
{
	collectData: function($super)
    {
    	formData = $super() + "&_selectedId=" + this.selectedId
    						+ "&dayDelta=" + this.dayDelta
    						+ "&minuteDelta=" + this.minuteDelta
    						+ "&allDay=" + this.allDay
    						+ "&updateType=" + this.updateType
    						;
        return formData;
    }
});
