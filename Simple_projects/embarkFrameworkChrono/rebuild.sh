#!/bin/bash
rm -r dist
rm app/js/index.js
npm run build
embark run