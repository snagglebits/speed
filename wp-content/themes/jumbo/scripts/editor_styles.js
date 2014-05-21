(function() {

	tinymce.create('tinymce.plugins.OboxButton', {
	
		createControl: function(n, cm) {
                switch (n) {
                        case 'oboxbutton':
                                var c = cm.createMenuButton('oboxbutton', {
                                        title : 'oboxbutton',
                                        image : template_directory+'/ocmx/images/oboxbutton.png',
                                        icons : false
                                });

                                c.onRenderMenu.add(function(c, m) {
                                        var sub;
                                        
                                        // Styled Boxes (Submenu)
                                        sub = m.addMenu({title : 'Styled boxes'});

                                        sub.add({title : 'Info', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<div class="obox-alert obox-info">Your Text Here</div> ');
                                        }});
                                        
                                        sub.add({title : 'Success', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<div class="obox-alert obox-success">Your Text Here</div> ');
                                        }});
                                        
                                        sub.add({title : 'Failure', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<div class="obox-alert obox-failure">Your Text Here</div>');
                                        }});
                                        
                                        
                                        // CSS Small Buttons (Submenu)
                                        sub = m.addMenu({title : 'Small CSS Buttons'});

                                        sub.add({title : 'Black', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-black obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Blue', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-blue obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Green', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-green obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Grey', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-grey obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Navy', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-navy obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Orange', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-orange obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Purple', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-purple obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Red', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-red obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Teal', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-teal obox-small">Small Button</a>');
                                        }});
                                        
                                        sub.add({title : 'White', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-white obox-small">Small Button</a>');
                                        }});
                                        
                                        
                                        // CSS Large Buttons (Submenu)
                                        sub = m.addMenu({title : 'Large CSS Buttons'});

                                        sub.add({title : 'Black', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a hhref="#" class="obox-button obox-black obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Blue', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-blue obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Green', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-green obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Grey', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-grey obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Navy', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-navy obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Orange', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-orange obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Purple', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-purple obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Red', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-red obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'Teal', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-teal obox-large">Large Button</a>');
                                        }});
                                        
                                        sub.add({title : 'White', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<a href="#" class="obox-button obox-white obox-large">Large Button</a>');
                                        }});
                                        
                                        
                                        // Columns (Submenu)
                                        sub = m.addMenu({title : 'Columns'});

                                        sub.add({title : '2 Columns', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<ul class="obox-grid obox-two-column"><li class="obox-column"><h4>Column 1</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 2</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li></ul>');
                                        }});
                                        
                                        sub.add({title : '3 Columns', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<ul class="obox-grid obox-three-column"><li class="obox-column"><h4>Column 1</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 2</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 3</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li></ul>');
                                        }});
                                        
                                        sub.add({title : '4 Columns', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<ul class="obox-grid obox-four-column"><li class="obox-column"><h4>Column 1</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 2</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 3</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 4</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li></ul>');
                                        }});
                                        
                                        sub.add({title : '5 Columns', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<ul class="obox-grid obox-five-column"><li class="obox-column"><h4>Column 1</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 2</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 3</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 4</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 5</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li></ul>');
                                        }});
                                        
                                        sub.add({title : '6 Columns', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<ul class="obox-grid obox-six-column"><li class="obox-column"><h4>Column 1</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 2</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 3</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 4</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 5</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li><li class="obox-column"><h4>Column 6</h4> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.</p></li></ul>');
                                        }});
                                        
                                        
                                        // Dropcaps
                                        m.add({title : 'Dropcaps', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<p class="obox-dropcaps">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa. Aliquam vitae nunc vestibulum mauris tempor suscipit id sed lacus. Vestibulum arcu risus, porta eget auctor id, rhoncus et massa. Aliquam erat volutpat.</p>');
                                        }});

										
										// Divider
                                        m.add({title : 'Divider', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<hr class="obox-divider" />');
                                        }});
                                        
                                        
                                        // Highlighted text
                                        m.add({title : 'Highlighted Text', onclick : function() {
                                                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<p class="obox-highlighted">Your Text Here</p>');
                                        }});
                                });

                                // Return the new menu button instance
                                return c;
                }

                return null;
        }

	});
	tinymce.PluginManager.add('oboxbutton', tinymce.plugins.OboxButton);
	
})();