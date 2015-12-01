/**
 * IDF MAP
 */
(function($) {
    $.extend(true, $.fn.mapael,
        {
            maps :{
                idf : {
                    width : 606,
                    height : 500,
                    getCoords : function (lat, lon) {
                        return {'x' : lat, 'y' : lon};
                    },
                    elems : {
                        "path6" : "m 285.25,201.65 1.15,0.46 5.23,-1.22 4.97,2.26 -0.42,4.98 -1.18,3.08 -6.3,-0.09 -1.74,-1.91 -2.54,-0.3 -4.27,-2.04 -3.41,1.35 -6.68,3.57 -2,0.15 -0.89,-0.89 -2.31,0.94 -3.08,-0.51 -4.54,-2.09 -3.28,-1.13 -3.05,-1.28 -2.18,-1.18 -2.3,0.93 -1.09,-2.08 -1.24,0.1 -2.36,-1.16 -1.38,-3.69 -6.09,-2.86 0.4,-2.29 1.59,-3.74 3.61,-2.84 2.45,0.84 1.23,-2.26 5.11,0.67 1.18,-2.73 4.98,-3.27 4.15,-2.42 2.59,-0.25 5.61,-0.09 3.58,-0 1.14,-0.01 4.91,0.23 1.79,1.94 0.53,2.64 0.42,2.21 2.64,2.07 0.65,2.09 0.47,6.98 0.24,2.31 0,0 0,0 -0.1,1.01 -0.62,3.65 0.73,0.99 z",
                        "path8" : "m 394.43,474.29 -7.73,4.97 -4.81,-0.71 -0.76,-2.31 0.26,-6.3 2.61,-2.79 0.13,-1.26 -3.1,-1.55 -2.27,1.05 -2.41,-0.81 -2.01,1.55 -2.55,-0.32 -2.29,1.06 -4.74,-1.93 4.62,5.61 0.24,2.43 -8.52,3.17 -4.16,4.88 -8.08,-0.17 -2.07,1.74 -0.73,0.05 -6.49,-7.18 -9.21,2.73 -6.88,-0.02 -1.88,-3.52 -8.6,0.07 -4.13,4.68 0.12,1.25 -11.6,-1.58 -4.85,1.33 -0.81,0.86 -3.42,-0.84 0.42,-2.32 4.4,-2.59 2.89,-4 -0.05,-2.35 2.99,-3.84 5.98,3.18 2.25,-3.25 -1.54,-6.26 1.73,-4.68 1.27,-0.35 0.72,-1.88 -1.42,-6.08 -0.85,-0.01 0.35,-4.87 -2.07,-0.81 -0.28,-3.71 -5.71,-0.21 -1.69,-2.02 -0.2,-2.6 -1.99,-1.74 -4.5,1.86 -1.88,-1.59 -1.14,0.49 -2.44,-1.01 -2.31,-3.17 -0.41,-1.1 0.26,-12.65 -4.63,-8.38 -1.87,-1.97 -0.76,-3.94 2.31,1.13 4.86,-1.57 3.58,1.04 -0.87,-5.05 2.83,-3.75 -2.92,-1.89 2.91,-2.43 2.49,0.47 -0.19,-2.55 8.47,-3.34 -2.21,-3.1 3.18,-2.48 5.29,0.78 3.98,-3.53 6.54,1.06 -7.64,-10.25 -3.17,-0.87 -0.12,-7.08 -0.08,-2.05 -1.57,-1.54 0.44,-0.69 1.63,-0.81 -0.84,-8.98 2.05,-1.62 0.46,-2.7 0.48,-5.49 -1.22,-0.05 -0.56,-2.4 -2.39,-0.58 3.12,-9.85 -2.62,-0.13 4.85,-7.4 0.47,-2.51 3.08,-1.99 -2.53,0.15 -0.88,-3.9 6.01,-5.26 0.3,-4.63 -4.19,-2.45 -2.21,-5.76 1.01,-0.8 4.97,-0.72 0.48,-3.97 1.43,-2.18 -3.64,-2.99 3.56,-5.66 2.45,-0.36 2.12,1.38 2.45,-2.67 2.42,-0.34 -0.93,-4.8 -2.24,-1 1.56,-2.71 -0.85,-0.78 -1.41,-2.43 -0.17,-0.68 3.19,-5.43 3.69,-3.41 -1.75,-4.78 3.04,-2.58 -0.5,-3.82 4.44,-0.19 -2.13,-4.75 -3.96,0.36 -1,-0.89 3.04,-7.27 -1.86,-1.57 1.29,-3.38 -1.08,-0.54 0.92,-2.65 -2.4,-7.78 -3.15,-7.46 2.23,-1.08 1.25,-3.42 -4.97,-0.39 0.68,-4.94 -2.83,-2.62 1.82,-1.9 5.01,-1.88 -0.13,-2.58 1.54,-2.08 0.24,-0.21 -0.85,-0.89 0.88,-5.85 2.64,-1.67 -0.04,-2.32 -1.65,-1.29 -1.01,-4.18 -6.49,-10.11 -0.12,-1.34 2.56,-0.73 1.07,-2.45 -1.03,-5.2 -1.1,-0.49 -1.44,-4.24 -3.26,0.99 -0.61,-1.09 -3.16,-0.74 -0.82,-3.63 2.49,0.48 4.67,-1.91 1.65,-4.66 2.64,-2.67 3.8,-0.23 -5.61,-4.75 4.66,-7.9 4.1,-3.44 0.99,-2.48 2.3,0.2 3.58,-5.39 1.87,3.38 2.63,-0.2 6.96,5.68 3.53,3.58 -0.27,2.31 -0.29,1.19 3.33,1.11 5.46,-6.09 2.7,7.79 6.6,-0.97 6.26,-4.82 -4.32,-3.05 5.08,0.16 -1.07,-2.24 1.98,-0.58 4.48,-2.86 4.18,4.82 2.44,0.84 2.49,-0.73 2.84,5.78 4.05,-0.49 4.64,-2.8 1.24,0.57 1.68,-3.23 5.78,2.76 2.48,-0.65 1.03,0.78 1.2,-0.33 0.84,-3.59 2.3,0.83 3.19,-1.83 1.05,0.65 0.81,5.5 3.45,0.96 1.06,-4.6 2.99,-1.76 2.27,-0.8 4.53,1.55 0.99,-0.7 8.09,1.32 -2.39,-4.1 -0.11,-2.39 3.97,-6.08 1.9,1.87 8.99,2.16 1.74,-0.68 0.61,0.75 3.81,0.19 2.99,2.33 3.82,0.3 -2.4,5.51 0.74,1.98 2.35,1.36 3.55,5.72 -0.21,2.34 2.51,2.4 -0.01,1.27 -2.44,0.94 -1.1,5.05 -3.37,1.99 -0.12,2.45 2.2,2.89 7.02,2.59 2.22,2.45 0.44,2.21 3.58,1.29 0.4,1.21 1.11,-0.43 0.54,4.53 4.69,0.97 1.47,4.73 1.99,5.09 -0.69,1.61 1.28,2.22 1.11,0.62 3.66,-1.07 5.36,-3.37 1.93,5.19 0.24,5.52 4.41,5.14 8.05,-4.55 1.45,-3.6 2.02,7.78 -1.22,5.25 2.74,3 0.38,5.41 1.16,0.73 4.87,-1.63 -1.77,3.69 2.47,1.04 3.72,-1.52 1.41,2.28 6.09,2.06 -0.73,3.09 3.27,1.82 2.09,-2.71 3.84,-0.55 1.6,6.51 -1.53,3.76 0.53,4.01 -1.6,1.18 -1.58,-2.78 -1.19,-0.51 -6.59,3.5 -3.76,-0.45 -3.41,-1.85 -2.67,2.97 0.36,1.28 3.5,1.74 5.06,0.34 0.48,5.19 -0.11,1.28 -3.49,1.55 -2.22,-1.23 -2.55,0.16 -3.26,8.7 0.52,2.48 2.54,0.82 4.95,-1.69 2.15,1.54 0.08,3.88 1.54,2.09 6.34,-0.36 -0.14,3.83 0.12,2.3 0,6.75 2.79,2.92 -1.34,0.2 -0.41,3.95 -3.66,1.74 -3.56,4.04 0.91,2.18 -0.93,0.99 4.21,5.06 -1.95,6.47 6.61,-1.16 3.94,-3.69 6.64,1.17 3.94,-1.06 -3.7,3.84 0.65,1.18 5.14,1.34 3.75,3.8 0.03,1.29 -12.13,4.53 -0.76,1.06 2.53,4.57 -5.94,0.88 -1.75,3.26 -4.18,2.91 -0.9,1 4.4,8.01 -0.14,3.25 -2.34,0.56 -5.65,4.45 -3.67,0.07 -5.76,-1.88 -2.27,2.13 5.05,6.06 2.64,6.02 -0.06,2.57 -3.65,-0.17 -4.32,1.87 -5.06,3.12 3.43,3.83 -0.12,2.6 2.32,3.16 -0.37,5.32 -1.91,1.85 -0.97,3.76 4.9,1.49 -1.78,2.29 4.08,-0.02 0.06,2.5 -1.54,7.29 -3.77,-0.32 -3.91,-2.99 -2.53,0.08 -2.34,2.81 -0.59,6.28 -1.96,1.36 0.04,-2.56 -1.26,-0.06 -1.38,2.1 -2.53,0.03 -1.66,0.42 -3.48,-1.45 -1.26,-0.05 -0.3,1.21 -7.14,-3.27 -0.4,1.26 -2.44,-0.06 -5.46,5.16 -6.36,-1.98 -3.1,1.04 -2.6,1.33 -2.77,-2.01 -2.28,0.5 -1.03,-2.5 -2.38,-1.21 -1.14,2.2 -5.84,1.84 -1.29,-2.06 -4.5,1.55 -2.01,1.64 -2.91,5.79 -0.99,-0.81 -0.22,-2.39 -2.57,0.13 -2.14,-1.33 -3.6,1.21 -4.47,-0.9 -3.09,7.32 0.8,4.77 -6.45,8.4 3.06,2.6 -1.92,1.66 2.51,4.26 -1.29,3.8 4.92,1.48 1.01,8.6 -3.86,0.38 -5.16,10.35 -1.77,4.93 -2.3,1.2 -2.12,-1.04 -4.49,2.18 -0.19,3.58 -4.04,0.65 -5.37,5.32 0.4,6 0,0 0,0 -9.43,1.53 -7.56,1.14 -1.08,0.17 z",
                        "path10" : "m 145.74,356.61 -1.21,-0.26 -2.62,0.05 -2.12,-1.55 -3.58,-0.89 -2.06,-4.43 -1.15,-3.59 -6.22,0.39 -2.16,-0.78 -0.36,-2.41 -1.78,-1.76 0.69,-2.1 -2.48,-2.85 0.76,-2.51 -3.23,-5.83 -0.1,-5.42 2.9,-10.45 -2.34,0.42 -3.39,-3.76 -0.87,-3.68 -3.41,-1.58 -2.43,1.02 -7.6,-2.02 0.27,-1.26 -2.12,-1.47 4.24,-8.59 -0.75,-2.33 -6.1,-0.54 -0.62,1.11 -1.5,-1.4 1.96,-0.81 -2.23,-0.65 -4.08,1.97 -2.27,-3.07 -0.11,-2.54 -1.88,-1.64 0.54,-2.27 -2.74,-2.65 0.63,-2.48 -5.27,0.33 -3.87,-3.65 -1.24,-1.36 0.96,-6.22 1.35,-3.62 -7.46,-3.03 0.11,-3.2 3.21,-1.92 -1.78,-0.57 0.54,-0.83 6.52,-8.66 1.34,-0.26 0.65,-1.61 0.61,-3.45 -5.03,-4.54 -5.21,-1.11 -0.49,-1.66 1.22,-2.34 -2.67,-4.55 0.72,-9.19 2.79,-2.09 0.08,-1.16 -2.18,-4.88 3.28,-2.25 0.12,-1.34 -2.11,-1.6 -2.4,-0.47 1.51,-5.09 -2.77,-2.53 -3.2,-1.33 -0.2,1.17 -3.2,-3.22 4.56,-7.03 -6.4,-6.31 1.51,-1.58 -0.67,-1.94 -0.28,-1.06 -0.57,-1.25 -3.91,-1.29 -2.33,1.17 -1.47,-2.13 0.91,-2.4 -2.46,-2.99 -0.07,0 2.48,-4.84 -2.54,0.22 -1.45,-5 5.98,-4.84 -1.25,-0.07 -1.41,-2.07 -3.61,1.68 -4,-0 -1.91,1.7 -2.29,-5.49 2.39,-0.85 2.47,-5.59 -1.61,-1.62 0.8,-1.98 -1.33,-1.5 -3.57,-3.03 -0.35,-3.89 -2.02,-3.38 0.83,-2.5 -1.01,-0.85 3.67,-3.77 3.79,3.78 2.57,0.8 4.32,-2.81 2.51,-7.27 -0.62,-2.51 1.59,1.7 1.17,4.52 6.45,-1.5 3.63,0.83 2.97,-2.48 5.67,-2.25 2.49,-0.37 1.18,2.3 1.38,2.63 1.51,-1.05 6.78,-2.81 6.18,0.99 4.26,2.78 2.44,2.52 -0.94,3.39 7.58,4.62 2.22,-2.1 0.91,0.68 3.97,0.21 0.07,-2.66 2.08,-3.18 2.87,2.16 4.77,0.01 1.26,-0.12 1.33,-3.12 -0.71,-2.33 4.83,-1.59 2.1,-0.09 4.33,2.88 0.19,1.77 6.12,2.89 -3.68,9.35 2.03,1.4 0.78,3.74 -0.83,2.42 0.63,-0.05 1.76,-1.52 3.42,-0.55 0.43,-5.08 6.44,-5.95 1.42,0.86 -0.42,1.64 6.43,7.75 2,-1.35 2.39,0.3 0.54,1.07 2.58,-0.53 3.67,1.55 2.66,-0.66 3.31,4.27 0.7,0.72 4.07,4.04 0.73,-1.09 5.13,-0.42 4.6,-2.45 1.85,2.54 3.4,-5.03 5.87,2.2 3.43,-3.65 1.41,3.83 -1.36,5.35 1.5,2.28 6.44,1.17 3.5,1.81 2.21,3.21 0.79,3.79 -0.02,1.46 -1.28,2.51 8.38,1.4 0.05,3.53 -1.84,2.1 1.45,4.48 -1.39,1.85 0.35,4 -6.75,3.72 -1.27,1.26 -2.85,5.9 -2.04,3.78 0.86,2.52 -0.87,2.29 2.41,4.2 -2.53,0.4 -1.08,3.79 0.66,3.27 0.76,2.76 -0.19,0.99 2.7,2.37 3.97,-0.47 2.35,5.52 -0.77,1.01 5.06,-0.45 1.67,1.89 0.22,2.53 3.64,1.01 0.62,1.12 -0.02,2.13 0.16,1.3 -1.11,0.7 -3.91,0.24 -1.78,-1.69 -2.59,-0.17 -0.78,0.98 1.24,3.46 -0.77,3.68 -3.66,-1.31 -3.47,1.95 -2.68,-0.07 -3.19,2.34 -0.02,1.35 -1.01,2.32 -4.43,-1.66 -3.37,1.31 -1.09,0.76 2.57,4.57 -0.73,2.55 0.68,1.3 -3.4,5.38 0.16,2.52 -2.19,-1.57 -1.89,4.89 -3.16,-1.36 -0.84,0.79 -2.79,0.03 -2.53,-0.01 -0.86,2.36 -1.26,0.18 -1.03,0.6 -1.25,5.8 -0.48,2.37 -3.55,-0.77 -0.43,2.33 2.2,4.48 3.73,0.27 0.27,3.72 1.48,1.94 0.26,0.21 3.84,3.56 -0.72,3.61 -5.11,1.19 -0.52,2.58 0.68,3.63 -3.58,4.15 -1.16,7.98 -8.92,0.26 -0.86,0.97 -4.37,-2.41 -6.37,-0.54 -1.02,5.1 7.18,5.35 3.62,0.19 0.29,2.6 -2.48,0.63 -0.97,-0.63 -2.85,1.68 -4.87,10.74 -0.33,5.58 -2.55,0.88 -1.68,2.11 -0.1,4.04 1.44,2.23 0,0 0,0 -0.61,3.75 -2.51,0.78 -1.48,2.18 z",
                        "relief4" : "m 267.28,409.03 -0.98,-0.64 -6.29,-6.27 -0.5,-2.49 -3.15,0.47 -1.24,0.55 -3.23,7.31 -2.21,0.78 -5.84,-2.34 -3.75,5.26 -2.52,1.15 0.86,-6.61 -2.63,-0.39 2.19,-5.26 -3.76,0.04 -4.41,-2.73 -1.94,-3.23 -6.38,8.12 -0.38,3.92 -2.76,-0.52 -0.48,0.91 -3.7,-0.75 -0.25,2.38 2.06,2.27 -0.1,1.63 -13.23,0.43 0.85,-3.99 -2.58,0.13 -4.27,4.74 -9.03,-0.48 -0.35,2.04 -2.15,1.55 -3.68,-1 -5.13,1.22 -3.93,-0.54 -3.87,-0.69 -4.4,-5.74 -0.67,-2.28 4.52,-2.12 -0.2,-3.56 1.77,-1.87 -2.98,-4.58 1.38,-6.55 3.07,-2.65 -2.6,-6.01 -2.66,-0.51 2.82,-7.25 -3.86,-2.06 -3.51,-0.83 -4.72,0.86 -0.13,-2.98 -0.99,-0.45 3.44,-3.61 -0.37,-5.17 1.48,-2.14 -2.26,-0.68 -0.85,-4.3 -2.17,-1.54 -1.42,-2.24 0.13,-4.04 1.69,-2.09 2.56,-0.86 0.38,-5.57 4.95,-10.71 2.86,-1.66 0.97,0.64 2.48,-0.61 -0.27,-2.6 -3.62,-0.21 -7.14,-5.4 1.06,-5.09 6.37,0.59 4.35,2.45 0.87,-0.96 8.93,-0.19 1.22,-7.98 3.62,-4.12 -0.65,-3.63 0.54,-2.58 5.12,-1.15 0.75,-3.6 -3.81,-3.59 -0.26,-0.21 -1.46,-1.95 -0.24,-3.73 -3.73,-0.3 -2.16,-4.49 0.44,-2.33 3.55,0.8 0.5,-2.37 1.29,-5.79 1.04,-0.59 1.27,-0.17 0.87,-2.36 2.53,0.03 2.79,-0.01 0.85,-0.78 3.15,1.39 1.92,-4.87 2.18,1.58 -0.14,-2.52 3.44,-5.35 -0.66,-1.3 0.75,-2.55 -2.53,-4.59 1.09,-0.76 3.38,-1.28 4.41,1.69 1.03,-2.32 0.03,-1.35 3.21,-2.32 2.68,0.09 3.49,-1.92 3.65,1.34 0.8,-3.68 -1.21,-3.47 0.79,-0.97 2.59,0.19 1.77,1.7 3.91,-0.21 1.11,-0.7 -0.15,-1.31 0.58,0.64 1,3.31 4.4,1.9 4.94,0.27 1.75,1.56 1.91,3.35 -2.39,2.84 0.98,2.41 1.29,0.17 4.82,-2.01 0.41,3.86 2.48,-0.38 1.92,-7.07 0.81,-0.72 1.77,1 2.47,2.78 3.47,0.94 4.11,-2.84 0.1,7.07 0.05,2.99 4.08,0.06 6.3,-2.27 0.81,3.21 5.38,-2.4 1.29,-0.51 0.69,1.85 2.12,2.27 -0.32,-2.52 3.34,-2.15 2.63,-0.22 0.62,-0.01 2.36,-0.56 6.57,-2.13 2.85,8.71 2.1,2.39 -0.7,0.56 1.07,1.93 3.4,0.54 1.19,3.67 5.84,-1.13 2.24,1 0.93,4.8 -2.42,0.34 -2.45,2.67 -2.12,-1.38 -2.45,0.36 -3.56,5.66 3.64,2.99 -1.43,2.18 -0.48,3.97 -4.97,0.72 -1.01,0.8 2.21,5.76 4.19,2.45 -0.3,4.63 -6.01,5.26 0.88,3.9 2.53,-0.15 -3.08,1.99 -0.47,2.51 -4.85,7.4 2.62,0.13 -3.12,9.85 2.39,0.58 0.56,2.4 1.22,0.05 -0.48,5.49 -0.46,2.7 -2.05,1.62 0.84,8.98 -1.63,0.81 -0.44,0.69 1.57,1.54 0.08,2.05 0.12,7.08 3.17,0.87 7.64,10.25 -6.54,-1.06 -3.98,3.53 -5.29,-0.78 -3.18,2.48 2.21,3.1 -8.47,3.34 0.19,2.55 -2.49,-0.47 -2.91,2.43 2.92,1.89 -2.83,3.75 0.87,5.05 -3.58,-1.04 -4.86,1.57 -2.31,-1.13 0.76,3.94 1.87,1.97 0,0 0,0 -0.98,2.12 -7.53,2.5 -0.57,-1.01 z",
                        "path14" : "m 249.04,243.57 -1.29,-0.17 -0.98,-2.41 2.39,-2.84 -1.91,-3.35 -1.75,-1.56 -4.94,-0.27 -4.4,-1.9 -1,-3.31 -0.58,-0.64 0.04,-2.13 -0.61,-1.12 -3.63,-1.04 -0.2,-2.53 -1.65,-1.91 -5.06,0.41 0.78,-1 -2.3,-5.54 -3.98,0.44 -2.68,-2.39 0.2,-0.99 -0.74,-2.76 -0.63,-3.28 1.11,-3.78 2.53,-0.39 -2.38,-4.22 0.88,-2.29 -0.84,-2.52 2.07,-3.77 2.89,-5.88 1.28,-1.25 6.78,-3.67 5.12,-4.59 2.78,-2.74 4.25,-3.46 5.15,-3.59 6.01,-1.84 5.29,1.22 5.93,2.54 0.24,3.88 -1.96,3.41 -1.66,1.58 -0.57,1.06 -1.56,0.73 1.52,5.29 -4.15,2.42 -4.98,3.27 -1.18,2.73 -5.11,-0.67 -1.23,2.26 -2.45,-0.84 -3.61,2.84 -1.59,3.74 -0.4,2.29 6.09,2.86 1.38,3.69 2.36,1.16 1.24,-0.1 1.09,2.08 2.3,-0.93 2.18,1.18 3.05,1.28 3.28,1.13 4.54,2.09 -0.74,1.25 -2.58,1.46 1.22,3.28 -1.4,5.26 1.81,2.38 -1.55,4.34 -1.05,1.53 -1.6,4.72 2.78,2.29 0,0 0,0 -1.92,7.07 -2.48,0.38 -0.41,-3.86 z",
                        "path16" : "m 314.39,203.48 0.14,-1.34 -5.5,-3.7 -0.51,0.47 -2.48,-2.76 -1.09,0.6 -0.84,-1.65 -3.81,-0.61 -7,2.28 -1.86,1.65 -2.52,-0.65 -2.08,1.51 -2.62,-0.2 -0.68,0.03 -0.24,-2.31 -0.47,-6.98 -0.65,-2.09 -2.64,-2.07 -0.42,-2.21 -0.53,-2.64 -1.79,-1.94 -4.91,-0.23 -1.14,0.01 -3.58,0 -5.61,0.09 -2.59,0.25 -1.52,-5.29 1.56,-0.73 0.57,-1.06 1.66,-1.58 1.96,-3.41 -0.24,-3.88 -5.93,-2.54 -5.29,-1.22 0.34,-0.16 -0.95,-2.96 2.63,-2.84 3.71,1.64 1.77,1.5 2.11,-0.47 1.26,1.68 2.7,-4.58 2.49,0.64 3.28,-3.32 2.5,0.88 1.66,0.3 6.34,5.94 2.94,-0.61 7.34,0.81 2.18,0.02 0.89,0.29 1.84,-3.25 6.31,-3.76 1.25,0.21 1.16,-0.99 0.36,-1.26 2.48,-0.94 5.49,-9.08 3.81,0.05 1.39,-2.12 3.26,-0.99 1.44,4.24 1.1,0.49 1.03,5.2 -1.07,2.45 -2.56,0.73 0.12,1.34 6.49,10.11 1.01,4.18 1.65,1.29 0.04,2.32 -2.64,1.67 -0.88,5.85 0.85,0.89 -0.24,0.21 -1.54,2.08 0.13,2.58 -5.01,1.88 -1.82,1.9 2.83,2.62 -0.68,4.94 4.97,0.39 -1.25,3.42 -2.23,1.08 3.15,7.46 2.4,7.78 -0.92,2.65 0,0 0,0 -5.69,-3.01 -0.4,-1.23 0.06,-2.39 z",
                        "path18" : "m 311.57,255.47 0.7,-0.56 -2.1,-2.39 -2.85,-8.71 -6.57,2.13 -2.36,0.56 -0.62,0.01 -2.63,0.22 -3.34,2.15 0.32,2.52 -2.12,-2.27 -0.69,-1.85 -1.29,0.51 -5.38,2.4 -0.81,-3.21 -6.3,2.27 -4.08,-0.06 -0.05,-2.99 -0.1,-7.07 -4.11,2.84 -3.47,-0.94 -2.47,-2.78 -1.77,-1 -0.81,0.72 -2.78,-2.29 1.6,-4.72 1.05,-1.53 1.55,-4.34 -1.81,-2.38 1.4,-5.26 -1.22,-3.28 2.58,-1.46 0.74,-1.25 3.08,0.51 2.31,-0.94 0.89,0.89 2,-0.15 6.68,-3.57 3.41,-1.35 4.27,2.04 2.54,0.3 1.74,1.91 6.3,0.09 1.18,-3.08 0.42,-4.98 -4.97,-2.26 -5.23,1.22 -1.15,-0.46 -1.69,3.11 -0.73,-0.99 0.62,-3.65 0.1,-1.01 0.68,-0.03 2.62,0.2 2.08,-1.51 2.52,0.65 1.86,-1.65 7,-2.28 3.81,0.61 0.84,1.65 1.09,-0.6 2.48,2.76 0.51,-0.47 5.5,3.7 -0.14,1.34 8.19,5.53 -0.06,2.39 0.4,1.23 5.69,3.01 1.08,0.54 -1.29,3.38 1.86,1.57 -3.04,7.27 1,0.89 3.96,-0.36 2.13,4.75 -4.44,0.19 0.5,3.82 -3.04,2.58 1.75,4.78 -3.69,3.41 -3.19,5.43 0.17,0.68 1.41,2.43 0.85,0.78 -1.56,2.71 0,0 0,0 -5.84,1.13 -1.19,-3.67 -3.4,-0.54 z",
                        "path20" : "m 229.81,162.99 -0.03,-3.53 -8.36,-1.47 1.3,-2.5 0.03,-1.46 -0.76,-3.79 -2.19,-3.22 -3.49,-1.84 -6.43,-1.22 -1.48,-2.29 1.4,-5.34 -1.38,-3.84 -3.45,3.63 -5.86,-2.25 -3.44,5 -1.83,-2.55 -4.62,2.42 -5.14,0.39 -0.74,1.08 -4.04,-4.07 -0.69,-0.73 -3.27,-4.29 -2.66,0.64 -3.65,-1.57 -2.58,0.51 -0.53,-1.07 -2.38,-0.31 -2.01,1.33 -6.37,-7.8 0.43,-1.64 -1.41,-0.87 -6.49,5.9 -0.47,5.08 -3.42,0.53 -1.77,1.51 -0.63,0.05 0.85,-2.41 -0.75,-3.74 -2.02,-1.42 3.75,-9.32 -6.1,-2.93 -0.18,-1.77 -4.31,-2.92 -2.1,0.07 -4.84,1.55 0.7,2.34 -1.35,3.11 -1.26,0.11 -4.77,-0.04 -2.86,-2.19 -2.11,3.16 -0.09,2.66 -3.97,-0.24 -0.9,-0.69 -2.23,2.08 -7.54,-4.68 0.97,-3.38 -2.42,-2.54 -4.24,-2.82 -6.17,-1.04 -6.8,2.76 -1.51,1.04 -1.36,-2.64 3.77,-3.12 -0.98,-0.75 0.24,-3.5 1.81,-3.14 5.51,-7.65 2.05,-2.05 -0.61,-4.51 2.47,-4.06 0.42,-0.56 -0.71,-1.12 2.09,-4.8 -0.72,-2.54 1.43,-1.99 -0.27,-3.51 1.44,-3.7 -0.66,-2.4 0.83,-2.54 6.02,-5.32 1.26,-2.35 1.67,-1.99 7.46,5.54 -1.2,0.56 -0.53,3.86 -4.72,2.16 -0.03,1.32 2.35,0.95 0.22,2.53 3.31,0.76 0.88,4.83 3.4,1.97 5.22,-3.89 0.14,-0.05 4.22,1.99 1.1,-1.88 4.85,3.68 3.64,-0.38 1.34,2.13 -0.69,2.49 3.86,-2.03 6.5,-1.38 0.58,-0.39 1.41,5 13.15,-4.04 0.88,1.02 2.7,-0 3.76,-1.41 2.95,-3.35 6.43,3.1 5.76,-5.02 4.21,-1.29 0.04,-0.11 3.12,-2.44 4.96,-1.72 2.84,-2.73 -0.05,1.26 2.41,0.71 1.37,6 5.1,0.86 3.67,-1.03 2.39,2.99 0.9,-0.93 2.48,0.66 2.62,2.48 -1.47,1.97 1.55,2.51 1.1,0.54 2.85,-2.28 -0.68,-2.29 2.74,1.32 5.06,-0.58 3.36,-1.66 3.3,5.19 -4.4,4.45 6.42,1.15 3.53,-0.78 1.75,-1.78 1.09,0.74 5.08,-1.31 0.63,-3.8 2.77,-2.87 0.45,-2.62 2.4,-0.36 2.85,0.2 9.45,14.5 3.57,-4.63 5.47,3.76 4,-0.87 7.77,2.5 -0.52,1.67 -0.92,2.93 5.37,-2.36 1.19,0.17 0.05,1.2 4.14,2.18 -0.16,1.2 5.66,2.25 0.43,2.32 -2.84,3.85 10.49,2.7 0.77,-7.58 2.25,-1.14 -0.14,1.25 2.44,-0.69 0.73,0.87 1.22,8.09 4.37,2.03 1.61,4.6 1.92,0.4 -4.66,7.91 5.61,4.74 -3.8,0.23 -2.64,2.67 -1.65,4.66 -4.67,1.91 -2.49,-0.48 0.82,3.63 3.16,0.75 0.61,1.09 -1.38,2.12 -3.81,-0.05 -5.49,9.08 -2.48,0.94 -0.36,1.26 -1.16,0.99 -1.25,-0.21 -6.31,3.76 -1.84,3.26 -0.89,-0.29 -2.17,-0.03 -7.34,-0.81 -2.94,0.61 -6.34,-5.94 -1.66,-0.3 -2.5,-0.88 -3.28,3.32 -2.49,-0.64 -2.7,4.58 -1.26,-1.68 -2.11,0.47 -1.77,-1.5 -3.71,-1.64 -2.63,2.84 0.95,2.96 -0.34,0.16 -6.01,1.84 -5.15,3.59 -4.25,3.46 -2.78,2.74 -5.12,4.59 -0.32,-4 1.41,-1.84 -1.41,-4.49 z",

                        "d75" : "m 279.32,194.87 0.73,0.99 1.69,-3.11 1.15,0.46 5.23,-1.22 4.97,2.26 -0.42,4.98 -1.18,3.08 -6.3,-0.09 -1.74,-1.91 -2.54,-0.3 -4.27,-2.04 -3.41,1.35 -6.68,3.57 -2,0.15 -0.89,-0.89 -2.31,0.94 -3.08,-0.51 -4.54,-2.09 -3.28,-1.13 -3.05,-1.28 -2.18,-1.18 -2.3,0.93 -1.09,-2.08 -1.24,0.09 -2.36,-1.16 -1.38,-3.69 -6.09,-2.86 0.4,-2.29 1.59,-3.74 3.61,-2.84 2.45,0.84 1.23,-2.26 5.11,0.67 1.18,-2.73 4.98,-3.27 4.15,-2.42 2.59,-0.25 5.61,-0.1 3.58,-0 1.14,-0.01 4.91,0.23 1.79,1.94 0.53,2.64 0.42,2.21 2.64,2.07 0.65,2.09 0.47,6.98 0.24,2.31 0,0 0,0 -0.1,1.01 z",
                        "d77" : "m 396.25,459.98 -1.08,0.17 -4.24,5.25 -7.73,4.97 -4.81,-0.71 -0.76,-2.31 0.26,-6.3 2.61,-2.79 0.13,-1.26 -3.1,-1.55 -2.27,1.05 -2.41,-0.81 -2.01,1.55 -2.55,-0.32 -2.29,1.06 -4.74,-1.93 4.62,5.61 0.24,2.43 -8.52,3.17 -4.16,4.88 -8.08,-0.17 -2.07,1.74 -0.73,0.05 -6.49,-7.18 -9.21,2.73 -6.88,-0.02 -1.88,-3.52 -8.6,0.07 -4.13,4.68 0.12,1.25 -11.6,-1.58 -4.85,1.33 -0.81,0.86 -3.42,-0.84 0.42,-2.32 4.4,-2.59 2.89,-4 -0.05,-2.35 2.99,-3.84 5.98,3.18 2.25,-3.25 -1.54,-6.26 1.73,-4.68 1.27,-0.35 0.72,-1.88 -1.42,-6.08 -0.85,-0.01 0.35,-4.87 -2.07,-0.81 -0.28,-3.71 -5.71,-0.21 -1.69,-2.02 -0.2,-2.6 -1.99,-1.74 -4.5,1.86 -1.88,-1.59 -1.14,0.49 -2.44,-1.01 -2.31,-3.17 -0.41,-1.1 0.26,-12.65 -4.63,-8.38 -1.87,-1.97 -0.76,-3.94 2.31,1.13 4.86,-1.57 3.58,1.04 -0.87,-5.05 2.83,-3.75 -2.92,-1.89 2.91,-2.43 2.49,0.47 -0.19,-2.55 8.47,-3.34 -2.21,-3.1 3.18,-2.48 5.29,0.78 3.98,-3.52 6.54,1.06 -7.64,-10.25 -3.17,-0.87 -0.12,-7.08 -0.08,-2.05 -1.57,-1.54 0.44,-0.69 1.63,-0.81 -0.84,-8.98 2.05,-1.62 0.46,-2.7 0.48,-5.49 -1.22,-0.05 -0.56,-2.4 -2.39,-0.58 3.12,-9.85 -2.62,-0.13 4.85,-7.4 0.47,-2.51 3.08,-1.99 -2.53,0.15 -0.88,-3.9 6.01,-5.26 0.3,-4.63 -4.19,-2.45 -2.21,-5.76 1.01,-0.8 4.97,-0.72 0.48,-3.96 1.43,-2.18 -3.64,-2.99 3.56,-5.66 2.45,-0.36 2.12,1.38 2.45,-2.67 2.42,-0.34 -0.93,-4.8 -2.24,-1 1.56,-2.71 -0.85,-0.78 -1.41,-2.43 -0.17,-0.68 3.19,-5.43 3.69,-3.41 -1.75,-4.78 3.04,-2.58 -0.5,-3.82 4.44,-0.19 -2.13,-4.75 -3.96,0.36 -1,-0.9 3.04,-7.27 -1.86,-1.57 1.29,-3.38 -1.08,-0.54 0.92,-2.65 -2.4,-7.78 -3.15,-7.46 2.23,-1.08 1.25,-3.42 -4.97,-0.39 0.68,-4.94 -2.83,-2.62 1.82,-1.9 5.01,-1.88 -0.13,-2.58 1.54,-2.08 0.24,-0.21 -0.85,-0.89 0.88,-5.85 2.64,-1.67 -0.04,-2.32 -1.65,-1.29 -1.01,-4.18 -6.49,-10.11 -0.12,-1.34 2.56,-0.73 1.07,-2.45 -1.03,-5.2 -1.1,-0.49 -1.44,-4.23 -3.26,0.99 -0.61,-1.09 -3.16,-0.74 -0.82,-3.63 2.49,0.48 4.67,-1.91 1.65,-4.66 2.64,-2.67 3.8,-0.23 -5.61,-4.75 4.66,-7.9 4.1,-3.44 0.99,-2.48 2.3,0.2 3.58,-5.39 1.87,3.38 2.63,-0.2 6.96,5.68 3.53,3.58 -0.27,2.31 -0.29,1.19 3.33,1.11 5.46,-6.09 2.7,7.79 6.6,-0.97 6.26,-4.82 -4.32,-3.05 5.08,0.16 -1.07,-2.24 1.98,-0.58 4.48,-2.86 4.18,4.82 2.44,0.84 2.49,-0.73 2.84,5.78 4.05,-0.49 4.64,-2.8 1.24,0.57 1.68,-3.23 5.78,2.76 2.48,-0.66 1.03,0.78 1.2,-0.33 0.84,-3.59 2.3,0.83 3.19,-1.83 1.05,0.65 0.81,5.5 3.45,0.96 1.06,-4.6 2.99,-1.76 2.27,-0.8 4.53,1.55 0.99,-0.7 8.09,1.31 -2.39,-4.1 -0.11,-2.39 3.97,-6.08 1.9,1.87 8.99,2.16 1.74,-0.68 0.61,0.75 3.81,0.19 2.99,2.33 3.82,0.3 -2.4,5.51 0.74,1.98 2.35,1.36 3.55,5.72 -0.21,2.34 2.51,2.39 -0.01,1.27 -2.44,0.94 -1.1,5.05 -3.37,1.99 -0.12,2.45 2.2,2.89 7.02,2.59 2.22,2.45 0.44,2.21 3.58,1.29 0.4,1.21 1.11,-0.43 0.54,4.53 4.69,0.97 1.47,4.73 1.99,5.1 -0.69,1.61 1.28,2.22 1.11,0.62 3.66,-1.07 5.36,-3.37 1.93,5.19 0.24,5.52 4.41,5.14 8.05,-4.55 1.45,-3.6 2.02,7.78 -1.22,5.25 2.74,3 0.38,5.41 1.16,0.73 4.87,-1.63 -1.77,3.69 2.47,1.04 3.72,-1.52 1.41,2.28 6.09,2.06 -1.73,5.09 4.27,1.82 2.09,-4.71 3.84,-0.55 1.6,6.51 -1.53,3.76 0.53,4.01 -1.6,1.18 -1.58,-2.78 -1.19,-0.51 -6.59,3.5 -3.76,-0.45 -3.41,-1.85 -2.67,2.96 0.36,1.28 3.5,1.74 5.06,0.34 0.48,5.19 -0.11,1.28 -3.49,1.55 -2.22,-1.23 -2.55,0.16 -3.26,8.7 0.52,2.48 2.54,0.81 4.95,-1.69 2.15,1.54 0.08,3.88 1.54,2.09 6.34,-0.36 -0.14,3.83 0.12,2.3 0,6.75 2.79,2.92 -1.34,0.2 -0.41,3.95 -3.66,1.74 -3.56,4.04 0.91,2.18 -0.93,0.99 4.21,5.06 -1.95,6.48 6.61,-1.16 3.94,-3.69 6.64,1.17 3.94,-1.06 -3.7,3.84 0.65,1.18 5.14,1.34 3.75,3.8 0.03,1.29 -12.13,4.53 -0.76,1.06 2.53,4.57 -5.94,0.88 -1.75,3.26 -4.18,2.91 -0.9,1 4.4,8.01 -0.14,3.25 -2.34,0.56 -5.65,4.45 -3.67,0.07 -5.76,-1.88 -2.27,2.13 5.05,6.06 2.64,6.02 -0.06,2.57 -3.65,-0.17 -4.32,1.87 -5.06,3.12 3.43,3.83 -0.12,2.6 2.32,3.16 -0.37,5.32 -1.91,1.85 -0.97,3.76 4.9,1.49 -1.78,2.29 4.08,-0.02 0.06,2.5 -1.54,7.29 -3.77,-0.31 -3.91,-2.99 -2.53,0.08 -2.34,2.81 -0.59,6.28 -1.96,1.36 0.04,-2.56 -1.26,-0.06 -1.38,2.09 -2.53,0.04 -1.66,0.42 -3.48,-1.45 -1.26,-0.05 -0.3,1.21 -7.14,-3.26 -0.4,1.26 -2.44,-0.06 -5.46,5.16 -6.36,-1.98 -3.1,1.04 -2.6,1.33 -2.77,-2.01 -2.28,0.5 -1.03,-2.5 -2.38,-1.21 -1.14,2.2 -5.84,1.84 -1.29,-2.06 -4.5,1.55 -2.01,1.64 -2.91,5.79 -0.99,-0.81 -0.22,-2.39 -2.57,0.13 -2.14,-1.33 -3.6,1.21 -4.47,-0.9 -3.09,7.32 0.8,4.77 -6.45,8.4 3.06,2.6 -1.92,1.66 2.51,4.26 -1.29,3.8 4.92,1.48 1.01,8.6 -3.86,0.38 -5.16,10.35 -1.77,4.93 -2.3,1.2 -2.12,-1.04 -4.49,2.18 -0.19,3.58 -4.04,0.65 -5.37,5.32 0.4,6 0,0 0,0 -9.43,1.53 z",
                        "d78" : "m 148.03,345.6 -1.5,2.17 -5.27,0.03 -1.21,-0.27 -2.62,0.03 -2.1,-1.57 -3.57,-0.91 -2.03,-4.45 -1.13,-3.59 -6.22,0.34 -2.15,-0.8 -0.34,-2.41 -1.77,-1.77 0.71,-2.1 -2.46,-2.87 0.78,-2.5 -3.18,-5.85 -0.06,-5.42 2.99,-10.42 -2.35,0.4 -3.36,-3.79 -0.84,-3.69 -3.4,-1.61 -2.44,1 -7.58,-2.07 0.28,-1.26 -2.11,-1.48 4.3,-8.55 -0.73,-2.33 -6.09,-0.59 -0.62,1.11 -1.49,-1.41 1.97,-0.8 -2.23,-0.66 -4.1,1.93 -2.25,-3.09 -0.09,-2.54 -1.86,-1.66 0.56,-2.26 -2.72,-2.68 0.65,-2.48 -5.27,0.29 -3.85,-3.68 -1.23,-1.37 1.01,-6.21 1.37,-3.61 -7.44,-3.09 0.14,-3.2 3.22,-1.89 -1.78,-0.58 0.55,-0.83 6.59,-8.6 1.35,-0.25 0.66,-1.6 0.64,-3.44 -4.99,-4.58 -5.2,-1.15 -0.48,-1.66 1.24,-2.33 -2.64,-4.57 0.79,-9.18 2.81,-2.07 0.09,-1.16 -2.14,-4.9 3.3,-2.22 0.13,-1.34 -2.09,-1.62 -2.39,-0.49 1.55,-5.08 -2.75,-2.55 -3.19,-1.35 -0.21,1.16 -3.18,-3.24 4.62,-6.99 -6.35,-6.36 1.52,-1.57 -0.65,-1.94 -0.27,-1.07 -0.56,-1.26 -3.9,-1.31 -2.34,1.15 -1.45,-2.14 0.92,-2.4 -2.44,-3 -0.07,0 2.52,-4.82 -2.54,0.2 -1.41,-5.01 6.02,-4.79 -1.25,-0.08 -1.39,-2.08 -3.62,1.65 -4,-0.04 -1.92,1.69 -2.25,-5.51 2.39,-0.83 2.52,-5.57 -1.59,-1.64 0.82,-1.97 -1.32,-1.51 -3.54,-3.05 -0.32,-3.89 -2,-3.4 0.85,-2.49 -1,-0.86 3.7,-3.74 3.76,3.81 2.56,0.81 4.34,-2.78 2.57,-7.24 -0.61,-2.51 1.58,1.72 1.14,4.53 6.46,-1.45 3.62,0.85 2.99,-2.45 5.69,-2.21 2.5,-0.35 1.16,2.31 1.36,2.63 1.51,-1.04 6.8,-2.76 6.17,1.04 4.24,2.82 2.42,2.54 -0.97,3.39 7.54,4.68 2.23,-2.08 0.9,0.69 3.97,0.24 0.09,-2.66 2.11,-3.16 2.86,2.19 4.77,0.04 1.26,-0.11 1.35,-3.11 -0.7,-2.34 4.84,-1.55 2.1,-0.07 4.31,2.92 0.18,1.77 6.1,2.93 -3.75,9.32 2.02,1.42 0.75,3.74 -0.85,2.41 0.63,-0.05 1.77,-1.51 3.42,-0.53 0.47,-5.08 6.49,-5.9 1.41,0.87 -0.43,1.64 6.37,7.8 2.01,-1.33 2.39,0.31 0.53,1.07 2.58,-0.51 3.65,1.57 2.66,-0.64 3.27,4.29 0.69,0.72 4.04,4.07 0.74,-1.08 5.14,-0.38 4.62,-2.42 1.83,2.55 3.44,-5 5.86,2.25 3.46,-3.63 1.38,3.84 -1.4,5.34 1.48,2.29 6.43,1.22 3.49,1.84 2.19,3.22 0.76,3.79 -0.03,1.46 -1.3,2.5 8.36,1.47 0.02,3.53 -1.86,2.08 1.41,4.49 -1.41,1.84 0.32,4 -6.78,3.67 -1.28,1.25 -2.89,5.88 -2.07,3.77 0.84,2.52 -0.88,2.29 2.38,4.22 -2.53,0.39 -1.11,3.78 0.63,3.28 0.74,2.76 -0.2,0.99 2.68,2.39 3.97,-0.44 2.31,5.54 -0.78,1 5.06,-0.41 1.65,1.91 0.2,2.53 3.63,1.04 0.61,1.12 -0.04,2.13 0.15,1.31 -1.11,0.7 -3.91,0.21 -1.77,-1.7 -2.59,-0.19 -0.79,0.97 1.21,3.47 -0.8,3.68 -3.65,-1.34 -3.49,1.92 -2.68,-0.09 -3.21,2.31 -0.03,1.35 -1.03,2.31 -4.41,-1.69 -3.38,1.28 -1.09,0.76 2.53,4.59 -0.75,2.55 0.66,1.3 -3.44,5.35 0.14,2.53 -2.17,-1.58 -1.92,4.87 -3.15,-1.39 -0.85,0.78 -2.79,0.01 -2.53,-0.03 -0.87,2.36 -1.27,0.17 -1.04,0.59 -1.29,5.79 -0.5,2.37 -3.55,-0.8 -0.44,2.33 2.16,4.49 3.73,0.3 0.24,3.72 1.46,1.95 0.26,0.21 3.81,3.59 -0.75,3.6 -5.12,1.15 -0.54,2.58 0.65,3.63 -3.62,4.12 -1.22,7.98 -8.93,0.19 -0.87,0.96 -4.35,-2.45 -6.37,-0.59 -1.06,5.09 7.14,5.4 3.62,0.21 0.27,2.6 -2.48,0.61 -0.97,-0.64 -2.86,1.66 -4.95,10.71 -0.38,5.57 -2.56,0.86 -1.69,2.09 -0.13,4.04 1.42,2.24 0,0 0,0 -0.64,3.74 z",
                        "d91" : "m 266.47,400.21 -0.57,-1.01 -2.11,0.94 -0.98,-0.64 -6.29,-6.27 -0.5,-2.49 -3.15,0.47 -1.24,0.55 -3.23,7.31 -2.21,0.78 -5.84,-2.34 -3.75,5.26 -2.52,1.15 0.86,-6.61 -2.63,-0.4 2.19,-5.26 -3.76,0.04 -4.41,-2.73 -1.94,-3.24 -6.38,8.12 -0.38,3.92 -2.76,-0.52 -0.48,0.91 -3.7,-0.75 -0.25,2.38 2.06,2.27 -0.1,1.63 -13.23,0.43 0.85,-3.99 -2.58,0.13 -4.27,4.74 -9.03,-0.48 -0.35,2.04 -2.15,1.55 -3.68,-1 -5.13,1.22 -3.93,-0.54 -3.87,-0.69 -4.4,-5.74 -0.67,-2.28 4.52,-2.12 -0.2,-3.56 1.77,-1.87 -2.98,-4.58 1.38,-6.55 3.07,-2.65 -2.6,-6.01 -2.66,-0.51 2.82,-7.25 -3.86,-2.06 -3.51,-0.83 -4.72,0.86 -0.13,-2.98 -0.99,-0.45 3.44,-3.61 -0.37,-5.17 1.48,-2.14 -2.26,-0.68 -0.85,-4.3 -2.17,-1.54 -1.42,-2.24 0.13,-4.04 1.69,-2.09 2.56,-0.86 0.38,-5.57 4.95,-10.71 2.86,-1.66 0.97,0.64 2.48,-0.61 -0.27,-2.6 -3.62,-0.21 -7.14,-5.4 1.06,-5.09 6.37,0.59 4.35,2.45 0.87,-0.96 8.93,-0.19 1.22,-7.98 3.62,-4.12 -0.65,-3.63 0.54,-2.58 5.12,-1.15 0.75,-3.6 -3.81,-3.59 -0.26,-0.21 -1.46,-1.95 -0.24,-3.72 -3.73,-0.3 -2.16,-4.49 0.44,-2.33 3.55,0.8 0.5,-2.37 1.29,-5.79 1.04,-0.59 1.27,-0.17 0.87,-2.36 2.53,0.03 2.79,-0.01 0.85,-0.78 3.15,1.39 1.92,-4.87 2.18,1.58 -0.14,-2.53 3.44,-5.35 -0.66,-1.3 0.75,-2.55 -2.53,-4.59 1.09,-0.76 3.38,-1.28 4.41,1.69 1.03,-2.31 0.03,-1.35 3.21,-2.31 2.68,0.09 3.49,-1.92 3.65,1.34 0.8,-3.68 -1.21,-3.47 0.79,-0.97 2.59,0.19 1.77,1.7 3.91,-0.21 1.11,-0.7 -0.15,-1.31 0.58,0.64 1,3.31 4.4,1.9 4.94,0.27 1.75,1.56 1.91,3.35 -2.39,2.84 0.98,2.41 1.29,0.17 4.82,-2.01 0.41,3.86 2.48,-0.38 1.92,-7.07 0.81,-0.72 1.77,1 2.47,2.78 3.47,0.94 4.11,-2.84 0.1,7.07 0.05,2.99 4.08,0.06 6.3,-2.27 0.81,3.21 5.38,-2.4 1.29,-0.51 0.69,1.85 2.12,2.27 -0.32,-2.52 3.34,-2.16 2.63,-0.22 0.62,-0.01 2.36,-0.56 6.57,-2.13 2.85,8.71 2.1,2.39 -0.7,0.56 1.07,1.93 3.4,0.54 1.19,3.67 5.84,-1.13 2.24,1 0.93,4.8 -2.42,0.34 -2.45,2.67 -2.12,-1.38 -2.45,0.36 -3.56,5.66 3.64,2.99 -1.43,2.18 -0.48,3.96 -4.97,0.72 -1.01,0.8 2.21,5.76 4.19,2.45 -0.3,4.63 -6.01,5.26 0.88,3.9 2.53,-0.15 -3.08,1.99 -0.47,2.51 -4.85,7.4 2.62,0.13 -3.12,9.85 2.39,0.58 0.56,2.4 1.22,0.05 -0.48,5.49 -0.46,2.7 -2.05,1.62 0.84,8.98 -1.63,0.81 -0.44,0.69 1.57,1.54 0.08,2.05 0.12,7.08 3.17,0.87 7.64,10.25 -6.54,-1.06 -3.98,3.52 -5.29,-0.78 -3.18,2.48 2.21,3.1 -8.47,3.34 0.19,2.55 -2.49,-0.47 -2.91,2.43 2.92,1.89 -2.83,3.75 0.87,5.05 -3.58,-1.04 -4.86,1.57 -2.31,-1.13 0.76,3.94 1.87,1.97 0,0 0,0 -0.98,2.12 z",
                        "d92" : "m 250.77,236.52 -0.41,-3.86 -4.82,2.01 -1.29,-0.17 -0.98,-2.41 2.39,-2.84 -1.91,-3.35 -1.75,-1.56 -4.94,-0.27 -4.4,-1.9 -1,-3.31 -0.58,-0.64 0.04,-2.13 -0.61,-1.12 -3.63,-1.04 -0.2,-2.53 -1.65,-1.91 -5.06,0.41 0.78,-1 -2.3,-5.54 -3.98,0.44 -2.68,-2.39 0.2,-0.99 -0.74,-2.76 -0.63,-3.28 1.11,-3.78 2.53,-0.39 -2.38,-4.22 0.88,-2.29 -0.84,-2.52 2.07,-3.77 2.89,-5.88 1.28,-1.25 6.78,-3.67 5.12,-4.59 2.78,-2.74 4.25,-3.46 5.15,-3.59 6.01,-1.84 5.29,1.22 5.93,2.54 0.24,3.88 -1.96,3.41 -1.66,1.58 -0.57,1.06 -1.56,0.73 1.52,5.29 -4.15,2.42 -4.98,3.27 -1.18,2.73 -5.11,-0.67 -1.23,2.26 -2.45,-0.84 -3.61,2.84 -1.59,3.74 -0.4,2.29 6.09,2.86 1.38,3.69 2.36,1.16 1.24,-0.09 1.09,2.08 2.3,-0.93 2.18,1.18 3.05,1.28 3.28,1.13 4.54,2.09 -0.74,1.25 -2.58,1.46 1.22,3.28 -1.4,5.26 1.81,2.38 -1.55,4.34 -1.05,1.53 -1.6,4.72 2.78,2.29 0,0 0,0 -1.92,7.07 z",
                        "d93" : "m 319.02,202.49 0.06,-2.38 -8.19,-5.53 0.14,-1.34 -5.5,-3.7 -0.51,0.47 -2.48,-2.76 -1.09,0.6 -0.84,-1.65 -3.81,-0.61 -7,2.28 -1.86,1.65 -2.52,-0.65 -2.08,1.51 -2.62,-0.2 -0.68,0.03 -0.24,-2.31 -0.47,-6.98 -0.65,-2.09 -2.64,-2.07 -0.42,-2.21 -0.53,-2.64 -1.79,-1.94 -4.91,-0.23 -1.14,0.01 -3.58,0 -5.61,0.1 -2.59,0.25 -1.52,-5.29 1.56,-0.73 0.57,-1.06 1.66,-1.58 1.96,-3.41 -0.24,-3.88 -5.93,-2.54 -5.29,-1.22 0.34,-0.16 -0.95,-2.96 2.63,-2.84 3.71,1.64 1.77,1.5 2.11,-0.47 1.26,1.68 2.7,-4.58 2.49,0.64 3.28,-3.32 2.5,0.88 1.66,0.3 6.34,5.94 2.94,-0.61 7.34,0.81 2.18,0.03 0.89,0.29 1.84,-3.25 6.31,-3.76 1.25,0.21 1.16,-0.99 0.36,-1.26 2.48,-0.94 5.49,-9.08 3.81,0.05 1.39,-2.12 3.26,-0.99 1.44,4.23 1.1,0.49 1.03,5.2 -1.07,2.45 -2.56,0.73 0.12,1.34 6.49,10.11 1.01,4.18 1.65,1.29 0.04,2.32 -2.64,1.67 -0.88,5.85 0.85,0.89 -0.24,0.21 -1.54,2.08 0.13,2.58 -5.01,1.88 -1.82,1.9 2.83,2.62 -0.68,4.94 4.97,0.39 -1.25,3.42 -2.23,1.08 3.15,7.46 2.4,7.78 -0.92,2.65 0,0 0,0 -5.69,-3.01 z",
                        "d94" : "m 312.54,249.04 -3.4,-0.54 -1.07,-1.93 0.7,-0.56 -2.1,-2.39 -2.85,-8.71 -6.57,2.13 -2.36,0.56 -0.62,0.01 -2.63,0.22 -3.34,2.16 0.32,2.52 -2.12,-2.27 -0.69,-1.85 -1.29,0.51 -5.38,2.4 -0.81,-3.21 -6.3,2.27 -4.08,-0.06 -0.05,-2.99 -0.1,-7.07 -4.11,2.84 -3.47,-0.94 -2.47,-2.78 -1.77,-1 -0.81,0.72 -2.78,-2.29 1.6,-4.72 1.05,-1.53 1.55,-4.34 -1.81,-2.38 1.4,-5.26 -1.22,-3.28 2.58,-1.46 0.74,-1.25 3.08,0.51 2.31,-0.94 0.89,0.89 2,-0.15 6.68,-3.57 3.41,-1.35 4.27,2.04 2.54,0.3 1.74,1.91 6.3,0.09 1.18,-3.08 0.42,-4.98 -4.97,-2.26 -5.23,1.22 -1.15,-0.46 -1.69,3.11 -0.73,-0.99 0.62,-3.65 0.1,-1.01 0.68,-0.03 2.62,0.2 2.08,-1.51 2.52,0.65 1.86,-1.65 7,-2.28 3.81,0.61 0.84,1.65 1.09,-0.6 2.48,2.76 0.51,-0.47 5.5,3.7 -0.14,1.34 8.19,5.53 -0.06,2.38 0.4,1.23 5.69,3.01 1.08,0.54 -1.29,3.38 1.86,1.57 -3.04,7.27 1,0.9 3.96,-0.36 2.13,4.75 -4.44,0.19 0.5,3.82 -3.04,2.58 1.75,4.78 -3.69,3.41 -3.19,5.43 0.17,0.68 1.41,2.43 0.85,0.78 -1.56,2.71 0,0 0,0 -5.84,1.13 z",
                        "d95" : "m 225.86,160.67 -1.41,-4.49 1.86,-2.08 -0.03,-3.53 -8.36,-1.47 1.3,-2.5 0.03,-1.45 -0.76,-3.79 -2.19,-3.22 -3.49,-1.84 -6.43,-1.22 -1.48,-2.29 1.4,-5.34 -1.38,-3.84 -3.45,3.63 -5.86,-2.25 -3.44,5 -1.83,-2.55 -4.62,2.42 -5.14,0.39 -0.74,1.08 -4.04,-4.07 -0.69,-0.72 -3.27,-4.29 -2.66,0.64 -3.65,-1.57 -2.58,0.51 -0.53,-1.07 -2.38,-0.32 -2.01,1.33 -6.37,-7.8 0.43,-1.64 -1.41,-0.87 -6.49,5.9 -0.47,5.08 -3.42,0.53 -1.77,1.51 -0.63,0.05 0.85,-2.41 -0.75,-3.74 -2.02,-1.42 3.75,-9.32 -6.1,-2.93 -0.18,-1.77 -4.31,-2.92 -2.1,0.07 -4.84,1.55 0.7,2.34 -1.35,3.11 -1.26,0.11 -4.77,-0.04 -2.86,-2.19 -2.11,3.16 -0.09,2.66 -3.97,-0.24 -0.9,-0.69 -2.23,2.08 -7.54,-4.68 0.97,-3.38 -2.42,-2.54 -4.24,-2.82 -6.17,-1.04 -6.8,2.76 -1.51,1.04 -1.36,-2.64 3.77,-3.12 -0.98,-0.75 0.24,-3.5 1.81,-3.14 5.51,-7.65 2.05,-2.05 -0.61,-4.51 2.47,-4.06 0.42,-0.56 -0.71,-1.12 2.09,-4.8 -0.72,-2.54 1.43,-1.99 -0.27,-3.51 1.44,-3.7 -0.66,-2.4 0.83,-2.54 6.02,-5.32 1.26,-2.35 1.67,-1.99 7.46,5.54 -1.2,0.56 -0.53,3.87 -4.72,2.16 -0.03,1.32 2.35,0.95 0.22,2.53 3.31,0.76 0.88,4.83 3.4,1.97 5.22,-3.89 0.14,-0.05 4.22,1.99 1.1,-1.88 4.85,3.68 3.64,-0.38 1.34,2.13 -0.69,2.49 3.86,-2.03 6.5,-1.38 0.58,-0.39 1.41,5 13.15,-4.04 0.88,1.02 2.7,-0 3.76,-1.41 2.95,-3.35 6.43,3.09 5.76,-5.03 4.21,-1.29 0.04,-0.1 3.12,-2.44 4.96,-1.72 2.84,-2.73 -0.05,1.26 2.41,0.71 1.37,6 5.1,0.86 3.67,-1.03 2.39,2.99 0.9,-0.93 2.48,0.66 2.62,2.48 -1.47,1.97 1.55,2.51 1.1,0.54 2.85,-2.28 -0.68,-2.29 2.74,1.32 5.06,-0.58 3.36,-1.66 3.3,5.19 -4.4,4.45 6.42,1.15 3.53,-0.78 1.75,-1.78 1.09,0.74 5.08,-1.31 0.63,-3.8 2.77,-2.87 0.45,-2.62 2.4,-0.36 2.85,0.2 9.45,14.5 3.57,-4.63 5.47,3.76 4,-0.87 7.77,2.5 -0.52,1.67 -0.92,2.93 5.37,-2.36 1.19,0.17 0.05,1.2 4.14,2.18 -0.16,1.2 5.66,2.26 0.43,2.32 -2.84,3.85 10.49,2.7 0.77,-7.58 2.25,-1.14 -0.14,1.25 2.44,-0.69 0.73,0.87 1.22,8.09 4.37,2.03 1.61,4.59 1.92,0.4 -4.66,7.91 5.61,4.74 -3.8,0.23 -2.64,2.67 -1.65,4.66 -4.67,1.91 -2.49,-0.48 0.82,3.63 3.16,0.75 0.61,1.09 -1.38,2.12 -3.81,-0.05 -5.49,9.08 -2.48,0.94 -0.36,1.26 -1.16,0.99 -1.25,-0.21 -6.31,3.76 -1.84,3.26 -0.89,-0.29 -2.17,-0.02 -7.34,-0.81 -2.94,0.61 -6.34,-5.94 -1.66,-0.3 -2.5,-0.88 -3.28,3.32 -2.49,-0.64 -2.7,4.58 -1.26,-1.67 -2.11,0.47 -1.77,-1.5 -3.71,-1.64 -2.63,2.84 0.95,2.96 -0.34,0.16 -6.01,1.84 -5.15,3.59 -4.25,3.46 -2.78,2.74 -5.12,4.59 -0.32,-4 z",
                    }
                }
            }
        }
    );
})(jQuery);
