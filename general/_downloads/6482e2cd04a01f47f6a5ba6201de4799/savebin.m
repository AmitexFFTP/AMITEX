%SAVEBIN write an array in a .bin file (AMITEX format)
%
%===========================================================================
%
% Usage :
%--------
%	savebin(X,fileout,datatype)
%
% Input :
%--------
%	X	: 	array (dimension)
%	fileout	:	name of the output file (.bin)
%	datatype:	conversion type (optionnal)
%			'uint8' (unsigned_char)
%			'uint16' (unsigned_short)
%			'uint32' (unsigned_int)
%			'uint64' (unsigned_long)
%			'int16' (short)
%			'int32' (int)
%			'int64' (long)
%			'int8' (char)
%			'single' (float)
%			'double' (double)
%
%       If datatype is omitted, the type is the class of X
%
% Output :     .bin file format, binary (big endian) 
%---------          with a small header : line 1 number of value
%                                         line 2 data type (vtk names)
%			
%---------------------------------------------------------------------------	
%	
% OCTAVE : OK 
% MATLAB : OK
%
%---------------------------------------------------------------------------
% AUTHOR : LG
%
% Modification :
%	21/06/2019 : first version
%
%===========================================================================
function savebin(X,fileout,datatype)

    if (nargin==2);datatype=class(X);end;
    if (nargin~=2 & nargin~=3);error('bad number of arguments');end;

    display(strcat('datatype=',datatype))

    [nx, ny, nz] = size(X);
    ntot=nx*ny*nz;
    fid = fopen(fileout, 'w');
    fprintf(fid, '%d\n', ntot);
if (strcmp(datatype,'uint8')==1);
    X=uint8(X);
    fprintf(fid, 'unsigned_char\n');
elseif (strcmp(datatype,'uint16')==1);
    X=uint16(X);
    fprintf(fid, 'unsigned_short\n');
elseif (strcmp(datatype,'uint32')==1);
    X=uint32(X);
    fprintf(fid, 'unsigned_int\n');
elseif (strcmp(datatype,'uint64')==1);
    X=uint64(X);
    fprintf(fid, 'unsigned_long\n');
elseif (strcmp(datatype,'int16')==1);
    X=int16(X);
    fprintf(fid, 'short\n');
elseif (strcmp(datatype,'int32')==1);
    X=int32(X);
    fprintf(fid, 'int\n');
elseif (strcmp(datatype,'int64')==1);
    X=int64(X);
    fprintf(fid, 'long\n');
elseif (strcmp(datatype,'int8')==1);
    X=int8(X);
    fprintf(fid, 'char\n');
elseif (strcmp(datatype,'single')==1);
    X=single(X);
    fprintf(fid, 'float\n');
elseif (strcmp(datatype,'double')==1);
    X=double(X);
    fprintf(fid, 'double\n');
else
error('type invalide');
end;

fwrite(fid,X(:),datatype,0,'b');


fclose(fid);
return


