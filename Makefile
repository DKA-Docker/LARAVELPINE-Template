SHELL := /bin/bash
.PHONY: default
.ONESHELL:

default:
	yarn run start

octane:
	yarn run start-octane
