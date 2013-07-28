var panels = new Array('panel1', 'panel2', 'panel3', 'panel4' );
      var selectedTab = 0;
      function showPanel(tab, name)
      {
      	selectedTab = tab;
      	for(i = 0; i < panels.length; i++)
        {        	
          document.getElementById("tabs").getElementsByTagName("a").item(i).className="";
        }
        if (selectedTab) 
        {
          selectedTab.style.backgroundColor = '';
          selectedTab.style.paddingTop = '';        
          selectedTab.className = 'hover';             
        }
        
        selectedTab.style.backgroundColor = 'white';
        selectedTab.style.paddingTop = '0px';
        selectedTab.style.marginTop = '0px';        
        for(i = 0; i < panels.length; i++)
        {
          document.getElementById(panels[i]).style.display = (name == panels[i]) ? 'block':'none';        
        }
        return false;
      }