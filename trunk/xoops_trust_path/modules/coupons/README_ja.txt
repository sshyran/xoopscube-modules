COUPONS ���W���[���@[color=cc0000][b]�e�X�g��[/b][/color]
XOOPS2 �܂��� XOOPS Cube Legacy �œ��삷�郂�W���[���ł�


//--------------------------------------
[b]����[/b]
- D3 ���W���[��
- altsys �K�{
- /class/smarty/plugins/function.xoopsdhtmltarea.php�K�{�id3forum�t�����Ă�����́A�z�z�A�[�J�C�u�ɓ������Ă���܂��j

- �v���O�C��
-- search
-- sitemap
-- whatsnew
-- d3pipes
-- xmobile
-- pical(daily/monthly)

- d3forum �R�����g����
-- /class/smarty/plugins/
--- function.d3forum_comment.php�id3forum�j
--- function.d3forum_comment_postscount.php�id3forum�j
-- ���p���邽�߂ɂ͈�ʐݒ�Őݒ肵�A�e���v���[�g�̃R�����g�A�E�g���폜���Ă�������
--- coupons_coupon.html, coupons_single.html

- RSS 2.0

- �N�[�|�������i�����W���[���ւ̖����@�\�j
-- /class/smarty/plugins/function.coupons.php �i���p����ꍇ�A�b�v���[�h�j
-- �N�[�|���\���̋L�q
--- <{coupons cp_dir=coupons embed_dir=shop item_field=lid item_id=$link.id mode=display}>
-- ���̓t�H�[�����o���L�q
--- <{coupons cp_dir=coupons embed_dir=shop item_field=lid item_id=$link.id mode=form}>
---- cp_dir : �N�[�|�����W���[���̃��[�g���̃f�B���N�g����
---- embed_dir : �N�[�|���𖄂ߍ��ޑ��̃��W���[���̃f�B���N�g����
---- item_field : ���ߍ��񂾑��̃A�C�e���E�L���Ȃǂ̎��ʂ��邽�߂̍���
---- item_id : ���ߍ��񂾑��̃A�C�e���E�L���Ȃǂ̎��ʂ��邽�߂̍��ڂɂ����ԍ�
---- mode : display / form

- �J�e�S���[�ʂɃv�����g�A�E�g�����o�C���̃f�U�C�����኱�ύX�ł���
-- ��肩���͕ʋL���܂��B

- ���o�C���ɂ���
-- ���W���[���P�ƂŃN�[�|����\�����܂��B
-- xmobile �𗘗p�����ꍇ�̓��X�g�\�����s�Ȃ��܂��B
-- [d]/common/qrcode/ ���C�u�����������QR�R�[�h��\�����܂��i�������Ă���܂��j�B[/d]

- english �̌���t�@�C���̓E�F�u�|��
�@
[pagebreak]
�@
//--------------------------------------
[b]TODO[/b]
- wizMobile �p�̃e���v���[�g��p�ӂ����o�C������̓o�^���\�ɂ���\��

//--------------------------------------
[b]�����[�X����[/b]
2008.9.4 v0.29
- Google Chart API �𗘗p���� QR �R�[�h�̐����ɕύX
-- �������Ă��� QR �R�[�h���C�u�������͂����܂����B
-- http://code.google.com/apis/chart/#qrcodes
- QR �R�[�h�������� URI ���Ԉ���Ă����̂��C��(0.29a)[2008.9.9](Thanks waka����)
- �N�[�|�������� Google Chart API �� QR�R�[�h����������Ă��Ȃ������s��C��(0.29b)[2008.9.9]
- �����ŃG���[���������Ă����̂��C���i0.29c�j(Thanks flannel����)[2009.7.28]
- Wizmobile, �g�ёΉ������_���[�Ōg�є��肳�ꂽ�ꍇ�A{$is_mobile} �� TRUE �����蓖�Ă�悤�ɂ��܂����i0.29c�j

2008.3.25 v0.28
- First Release(0.282)
- ja_utf8 �̌���t�@�C����p�ӂ��܂���(0.283)
- xmobile�v���O�C���̕s��C��(0.284)[2008.3.28]
- �u���b�N�̃I�v�V�����s��C��(0.28e)[2008.4.6]
- include/functions.php �኱�C��(0.28f)[2008.4.14]
- xmobile �̒P�ƕ\���y�[�W����N�[�|���̒P�ƃy�[�W�փ��_�C���N�g(0.28g)[2008.5.30]
-- {xoops_trust_path}/modules/coupons/class/XmobilePlugin.class.php
