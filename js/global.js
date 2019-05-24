var wait_cnt = 0;
var root_prefix = '/GoMobile/';

function setWait()
{
	var wait_obj = document.getElementById("waiting");

	if (wait_cnt == 0)
	{
		if (wait_obj == undefined)
		{
			var mwait_div = document.createElement("div");

			mwait_div.style.position = "fixed";
			mwait_div.style.width = "2000px";
			mwait_div.style.height = "1000px";
			mwait_div.style.left = 0;
			mwait_div.style.border = 0;
			mwait_div.style.padding = 0;
			mwait_div.style.top = 0;
			mwait_div.style.display="inline";
			mwait_div.style.background = "rgb(233, 233, 233)";
			mwait_div.style.opacity = 0.3;
			mwait_div.style.filter='gray() alpha(opacity=25)';
			mwait_div.style.zIndex = "400";
			mwait_div.setAttribute("id","waiting");

			var div = document.createElement("div");
			div.style.position = "fixed";

			var win_width=0, win_height=0;
			var isIE6CSS = (document.compatMode && document.compatMode.indexOf("CSS1") >= 0) ? true : false;

			if (window.innerWidth)
			{
				win_width = window.innerWidth;
				win_height = window.innerHeight;
			}
			else if (isIE6CSS != null && isIE6CSS != undefined)
			{
				win_width = document.body.parentElement.clientWidth;
				win_height = document.body.parentElement.clientHeight;
			}
			else if (document.body && document.body.clientWidth)
			{
				win_width = document.body.clientWidth;
				win_height = document.body.clientHeight;
			}

			div.style.left = win_width/2 + "px";
			div.style.top = win_height/2 + "px";

			var img = document.createElement("img");
			img.src = root_prefix + "/images/refresh.gif";
			img.style.background = "transparent";
			img.style.opacity = 1;
			div.appendChild(img);
			mwait_div.appendChild(div);
			document.body.appendChild(mwait_div);		
		}
		else
		{
			$(wait_obj).show();
		}
	}
	wait_cnt++;
}

function unsetWait()
{	
	wait_cnt--;	

	if (wait_cnt==0)
	{
		var wait_obj = document.getElementById("waiting");
		if (wait_obj != undefined)
		{
			$(wait_obj).hide();
		}
	}
}
