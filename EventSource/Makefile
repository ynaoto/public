#
# Copyright (c) 2013 Naoto Yoshioka
#

all: httpd-extra.conf
	@echo all done.

httpd-extra.conf: httpd-extra.conf.in
	cwd=`pwd`; sed "s@===HERE===@$${cwd}@g" $< >$@
	@echo '******************************************************************************'
	@echo "!!! IMPORTANT !!!"
	@echo
	@echo "Please add the following line to your httpd.conf"
	@echo
	@cwd=`pwd`; echo "Include $${cwd}/$@"
	@echo
	@echo '******************************************************************************'

JQ = "http://code.jquery.com/jquery-1.9.1.min.js"	\
     "http://code.jquery.com/ui/1.10.0/jquery-ui.min.js"	\
     "http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css"

test::
# doesn't work. the target file is truncated to zero.
	for f in $(JQ); do wget -O `basename $$f` $$f; done
#	for f in $(JQ); do wget $$f -O `basename $$f`; done
#	for f in $(JQ); do wget -O - $$f >`basename $$f`; done
# works (the last one is best)
#	for f in $(JQ); do wget -N $$f; done
#	for f in $(JQ); do curl $$f >`basename $$f`; done
#	for f in $(JQ); do curl -R -o `basename $$f` $$f; done
