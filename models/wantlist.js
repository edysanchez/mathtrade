define(['backbone','models/item','underscore','models/wildcard'],function(Backbone,Item,_,Wilcard){
	return Backbone.Collection.extend({
		model:Item,
		comparator:'pos',
		addToEnd: function(m) {
			m.set('pos',this.models.length-1,{silent:true});
			this.add(m);
		},

		setOrder:function(order) {
			var o = 0;
			_.each(order,function(i){
				var p = i.split('_');
				this.get(p[1]).set('pos',o,{silent:true});
				o++;
			}.bind(this));
			this.sort();
			this.trigger('repaint');
		},
		/**
		 * Format the want list in order to send it to the server	
		 * @return string of the [{id:1,t:"i"}]
		 */
		serialize:function() {
			var d = [];
			this.each(function(i){
				var o = {
					id:i.get('id') || i.cid,
					t: i instanceof Wilcard ? 2:1
				};
				d.push(o);
			});
			return JSON.stringify(d);
		}
	});
});