sniff:
	@./vendor/bin/phpcs --standard=PSR2 \
		src/Hitch

mess:
	@./vendor/bin/phpmd \
		src/Hitch \
		text \
		codesize,controversial,design,naming,unusedcode

.PHONY: sniff mess
