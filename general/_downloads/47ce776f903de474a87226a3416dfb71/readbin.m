
%READBIN read an array from a .bin file (AMITEX format)
%
%===========================================================================
%
% Usage :
%--------
%	X = readbin(filein)
%
% Input :
%--------
%	X	: 	array (1 dimension)
%	filein	:	name of the binary input file
%			with a small header : 	line 1 number of value
%                                         	line 2 data type (vtk names)
%
%
% Output :     .bin file format, binary (big endian) 
%---------          with a small header : line 1 number of value
%                                         line 2 data type (vtk names)
%	X	: 	array (1 dimension)
%	
%	The type of X is given by a vtk type in the header of the .bin file
%	according to the following equivalence : 
%		'matlab_type' (vtk type)
%		'uint8' (unsigned_char)
%		'uint16' (unsigned_short)
%		'uint32' (unsigned_int)
%		'uint64' (unsigned_long)
%		'int16' (short)
%		'int32' (int)
%		'int64' (long)
%		'int8' (char)
%		'single' (float)
%		'double' (double)
%		
%---------------------------------------------------------------------------	
%	
% OCTAVE :  
% MATLAB : 
%
%---------------------------------------------------------------------------
% AUTHOR : LG
%
% Modification :
%	08/01/2020 : first version (copy from AMITEX_FFT3dev/fonctions_pre)
%
%===========================================================================

function X = readbin(filein)

fid = fopen(filein, 'r');

N = str2num(deblank(fgetl(fid)))
type = deblank(fgetl(fid))
%
% conversion types (vtk-> matlab)
%
if (strcmp(type,'unsigned_char')==1);
  type='uint8';
elseif (strcmp(type,'unsigned_short')==1);
  type='uint16';
elseif (strcmp(type,'unsigned_int')==1);
  type='uint32';
elseif (strcmp(type,'unsigned_long')==1);
  type='uint64';
elseif (strcmp(type,'char')==1);
  type='int8';
elseif (strcmp(type,'short')==1);
  type='int16';
elseif (strcmp(type,'int')==1);
  type='int32';
elseif (strcmp(type,'long')==1);
  type='int64';
elseif (strcmp(type,'float')==1);
  type='single';
elseif (strcmp(type,'double')==1);
  type='double';
else
  error('error in .bin file : invalid vtk type in line 2');
end

type1=type;
X=fread(fid,N,type,0,'b');

return

