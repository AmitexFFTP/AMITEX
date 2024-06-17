%READFIELDVTK read an image (3D array) from VTK file (legacy format)
%
%===========================================================================
%
% Usage :
%--------
%	[X,dx,dy,dz,nx,ny,nz,S,datatype] = readfieldvtk(nomfic)
%
% Input :
%--------
%	filein	:	name of the vtk file
%			mist satisfay the Legacy File format 
%         (see https://vtk.org/wp-content/uploads/2015/04/file-formats.pdf)
%
% Output : 
%---------	
%	X 	:	3D image (3D array)
%	dx,dy,dz:	voxel sizes
%	nx,ny,z	:	array sizes
%	S	:	fiel name
%	datatype:	type of data read (string)
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
function [X,dx,dy,dz,nx,ny,nz,S,datatype] = readfieldvtk(filein)


fid=fopen(filein,'r');
%ouverture dun fichier en reading
%
%lecture des dimensions OK
%
A='aaaaaaaaaa';
while (strcmp(A,'DIMENSIONS')==0);
%comparaison de deux chaines de caracteres
ligne = fgetl(fid);
if (size(ligne,2)>=10);
A = ligne(1:10);
end;
end;
tmp=[];
tmp = sscanf(ligne(11:size(ligne,2)),'%d');
nx = tmp(1)-1;ny=tmp(2)-1;nz=tmp(3)-1;
%
%lecture des espacements OK
%
A='aaaaaaa';
while (strcmp(A,'SPACING')==0);
ligne = fgetl(fid);
if (size(ligne,2)>=7);
A = ligne(1:7);
end;
end;
tmp=[];
tmp = sscanf(ligne(8:size(ligne,2)),'%f');
dx = tmp(1);dy=tmp(2);dz=tmp(3);

%
%lecture du nom et du type
%
A='aaaaaaa';
while (strcmp(A,'SCALARS')==0);
ligne = fgetl(fid);
if (size(ligne,2)>=7);
A = ligne(1:7);
end;
end;
tmp=[];
tmp = textscan(ligne(8:size(ligne,2)),'%s');
S=char(tmp{1}(1,:));
datatype=char(tmp{1}(2,:));

%
%recherche du debut du champ
%
A='aaaaaa';
while (strcmp(A,'LOOKUP')==0);
ligne = fgetl(fid);
if (size(ligne,2)>=6);
A = ligne(1:6);
end;
end;

%
% conversion des types (vtk-> matlab)
%
if (strcmp(datatype,'unsigned_char')==1);
  datatype='uint8';
elseif (strcmp(datatype,'unsigned_short')==1);
  datatype='uint16';
elseif (strcmp(datatype,'unsigned_int')==1);
  datatype='uint32';
elseif (strcmp(datatype,'unsigned_long')==1);
  datatype='uint64';
elseif (strcmp(datatype,'char')==1);
  datatype='int8';
elseif (strcmp(datatype,'short')==1);
  datatype='int16';
elseif (strcmp(datatype,'int')==1);
  datatype='int32';
elseif (strcmp(datatype,'long')==1);
  datatype='int64';
elseif (strcmp(datatype,'float')==1);
  datatype='float';
elseif (strcmp(datatype,'double')==1);
  datatype='double';
else
  error('invalid type in the vtk file');
end


%
% lecture des données
%
type1=datatype;
if (strcmp(type1,'float')==1);type1='single';end;
B=fread(fid,nx*ny*nz,type1,0,'b');

X=reshape(B,[nx ny nz]);
%
%
fclose(fid);

return;
