%SAVEFIELDVTK write a 3D array in a VTK file
%
%===========================================================================
%
% Usage :
%--------
%	savefieldvtk(X,dx,dy,dz,ficname,varname,datatype)
%
% Input :
%--------
%	X	: 	3D array (nx,ny,nz)
%	dx,dy,dz:	voxel size dimension 
%	ficname	:	file name with extension .vtk
%	varname	:	variable name 
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
%       If type is omitted, the type is the class of X
%
% Output :
%---------
%	'ficname': 	vtk file format, binary (big endian), CELL_DATA
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
%	18/06/2019 : first version
%
%===========================================================================
function savefieldvtk(X,dx,dy,dz,ficname,varname,datatype)

    if (nargin==6);datatype=class(X);end;
    if (nargin~=6 & nargin~=7);error('bad number of arguments');end;

    display(strcat('datatype=',datatype))

    [nx, ny, nz] = size(X);
    fid = fopen(ficname, 'w');
    fprintf(fid, '# vtk DataFile Version 4.5\n');
    fprintf(fid, 'Materiau\n');
    fprintf(fid, 'BINARY\n');
    fprintf(fid, 'DATASET STRUCTURED_POINTS\n');
    fprintf(fid, 'DIMENSIONS    %d   %d   %d\n', nx+1, ny+1, nz+1);
    fprintf(fid, 'ORIGIN    0.000   0.000   0.000\n');
    fprintf(fid, 'SPACING    %f    %f   %f\n', dx, dy, dz);
    fprintf(fid, 'CELL_DATA   %lu\n', nx*ny*nz);

if (strcmp(datatype,'uint8')==1);
    X=uint8(X);
    fprintf(fid, 'SCALARS %s unsigned_char\n',varname);
elseif (strcmp(datatype,'uint16')==1);
    X=uint16(X);
    fprintf(fid, 'SCALARS %s unsigned_short\n',varname);
elseif (strcmp(datatype,'uint32')==1);
    X=uint32(X);
    fprintf(fid, 'SCALARS %s unsigned_int\n',varname);
elseif (strcmp(datatype,'uint64')==1);
    X=uint64(X);
    fprintf(fid, 'SCALARS %s unsigned_long\n',varname);
elseif (strcmp(datatype,'int16')==1);
    X=int16(X);
    fprintf(fid, 'SCALARS %s short\n',varname);
elseif (strcmp(datatype,'int32')==1);
    X=int32(X);
    fprintf(fid, 'SCALARS %s int\n',varname);
elseif (strcmp(datatype,'int64')==1);
    X=int64(X);
    fprintf(fid, 'SCALARS %s long\n',varname);
elseif (strcmp(datatype,'int8')==1);
    X=int8(X);
    fprintf(fid, 'SCALARS %s char\n',varname);
elseif (strcmp(datatype,'single')==1);
    X=single(X);
    fprintf(fid, 'SCALARS %s float\n',varname);
elseif (strcmp(datatype,'double')==1);
    X=double(X);
    fprintf(fid, 'SCALARS %s double\n',varname);
else
error('type invalide');
end;


fprintf(fid, 'LOOKUP_TABLE default\n');
fwrite(fid,X(:),datatype,0,'b');


fclose(fid);
return


