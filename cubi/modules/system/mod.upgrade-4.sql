ALTER TABLE  `user` ADD  `smartcard` VARCHAR( 255 ) NULL AFTER  `email` ;

ALTER TABLE  `user` ADD UNIQUE (
`smartcard`
);
