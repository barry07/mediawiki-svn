/* @(#) $Header$ */
/* This source code is in the public domain. */
/*
 * Willow: Lightweight HTTP reverse-proxy.
 * wconfig: configuration.
 */

#ifndef WCONFIG_H
#define WCONFIG_H

#include <sys/types.h>
#include <netinet/in.h>

struct listener {
	char		*name;
	char		*host;
	int 		 port;
struct	sockaddr_in	addr;
};
extern int nlisteners;
extern struct listener **listeners;

struct cachedir {
	char	*dir;
	size_t	 maxsize;
};

extern struct configuration {
	int		 foreground;
const	char		*access_log;
struct	cachedir	*caches;
	int		 ncaches;
} config;

void wconfig_init(const char *);

#endif
