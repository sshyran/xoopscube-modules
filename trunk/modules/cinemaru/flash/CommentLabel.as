//
// license http://www.opensource.org/licenses/mit-license.php MIT License
// 

package
{
	import mx.controls.Image;
	import mx.controls.Label;
	import mx.core.Application;

	public class CommentLabel extends Label
	{
		public var comment_time:uint = 0;
		public var flg_show:Boolean = false;
		public var flg_used:Boolean = false;
		public var app:Application = null;
		public var swf:Image = null;
		public var has_swf:Boolean = false;
		public var sp_cmd:Number = 0;
		public var swf_no:Number = 0;
		public var my_id:Number = 0;
		
		public function CommentLabel():void
		{
			super();
		}
		
		public function set_x(_x:Number):void {
			this.x = _x;
		}
		
		public function dec_x(n:Number):void {
			this.x -= n;
		}
	}
}